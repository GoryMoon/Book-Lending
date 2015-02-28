<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Html\HtmlFacade as HTML;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class BooksController extends Controller {

	protected $book;
	protected $category;

	public function __construct(Book $book, Category $category)
	{
		$this->book = $book;
		$this->category = $category;
	}

	/**
	 * Display a listing of the resource.
	 * GET /books
	 *
	 * @return Response
	 */
	public function index()
	{
		$breaks = array("<br />","<br>","<br/>"); 
		$books = $this->book->with('authors', 'categories')->get();

		foreach ($books as $value) {
			$value->description = str_ireplace($breaks, "<br>", $value->description);
			$value->genres = implode('<br>', $this->reformatCategories($value->categories->toArray(), true));

			$url = $value->imageUrl;
			if (!str_contains($url, 'no_book_cover.jpg') && !str_contains($url, 'http')) {
				$url = '/storage/' . $url; 
			} elseif (!str_contains($url, 'http')) {
				$url = '/images/no_book_cover.jpg';
			}
			$value->image = HTML::image($url, null, array('height' => '100px'));
		}

		return View::make('books.index')->with('books', $books);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /books/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make("books.create")->with('genres', $this->reformatGenres($this->category->select('id','name')->get()->toArray()));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /books
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		return $this->saveBookInfo($request);
	}

	private function saveBookInfo(Request $request, $id = null, $edit = false)
	{
		if ($request->input('_token') !== Session::token()) {
            return abort(400);
        }

        if (!$this->book->isValid($inputs = $request->only('isbn', 'title', 'author', 'genres', 'description', 'amount', 'image', 'imageUrl'), $edit)) {
			return Redirect::back()->withInput()->withErrors($this->book->errors);
		}

        $isbn = $inputs['isbn'];
        $title = $inputs['title'];
        $authors = $inputs['author'];

		$genres = array_map(function($word) { return ucfirst($word); }, $inputs['genres']);
        $desc = $inputs["description"];
        $desc = str_replace(array("\r\n", "\n\r", "\r", "\n"), "", nl2br("$desc"));
        $amount = intval($inputs['amount']);
        $imageUrl = $this->uploadImage($request, $isbn, $inputs['imageUrl']);
        $authors =  explode("; ", $authors);

        $newBook = null;
        if ($id !== null) 
        	$newBook = Book::firstOrCreate(['id' => $id]);
        else
        	$newBook = new Book;
       	$newBook->isbn = $isbn; 
        $newBook->title = $title;
        $newBook->description = $desc;
        $newBook->amount = $amount;
        $newBook->imageUrl = $imageUrl;

        $newBook->save();

        /* START HANDLE AUTHOR CHANGES */
        $bookAuthors = $newBook->authors()->getResults();
        $toRemove = array();
        $toAdd = array();
        foreach ($authors as $author) { 
        	$author = Author::firstOrCreate(array('name' => $author));

            if (!$edit) {
                $author->books()->save($newBook);
            } else {
                $toRemove = $this->filterItemFromMaster($bookAuthors, $author, $toRemove);
                $toAdd = $this->filterItemFromMaster($bookAuthors, $author, $toAdd, true);
            }
        }

        $toAdd = $this->getValueFromFilter($toAdd, 'false');
        $toRemove = $this->getValueFromFilter($toRemove, 'false');

        if (count($toAdd) > 0) {
            $newBook->authors()->attach($toAdd);
        }

        if (count($toRemove) > 0) {
            $newBook->authors()->detach($toRemove);
        }
        /* END HANDLE AUTHOR CHANGES */

        /* START HANDLE GENRE CHANGES */
        $categories = $newBook->categories()->getResults();
        $checkedGenres = array();
        foreach ($genres as $name) {
            $genre = null;
            if (is_numeric($name)) {
                $genre = Category::find($name);
            } else {
                $genre = Category::firstOrCreate(array('name' => $name));
                $genre->name = $name;
                $genre->save();
            }
        	if (!$edit) {
                $genre->books()->save($newBook);
            } else {
                $checkedGenres = $this->filterItemFromMaster($categories, $genre, $checkedGenres);
            }
        }

        $checkedGenres = $this->getValueFromFilter($checkedGenres, 'false');

        if (count($toAdd) > 0) {
            $newBook->authors()->attach($toAdd);
        }
        /* END HANDLE GENRE CHANGES */

		return Redirect::route('admin.books.index');
	}

    private function filterItemFromMaster($master, $item, $storedFilters, $storedKeyIsItem = false)
    {
        $storedKey = null;
        for ($i = 0; $i < count($master); $i++) {
            if (!$storedKeyIsItem)
                $storedKey = $master[$i];
            else
                $storedKey = $item;
            if ($master[$i]->id != $item->id) {
               $storedFilters = array_add($storedFilters, $storedKey->id, 'false');
            } else {
                $storedFilters = array_add($storedFilters, $storedKey->id, 'true');
                if (array_key_exists($storedKey->id, $storedFilters)) {
                   $storedFilters = array_set($storedFilters, $storedKey->id, 'true');
                }
            }
        }
        return $storedFilters;
    }

    private function getValueFromFilter($filter, $valueInFilter)
    {
        return array_keys(array_where($filter, function($key, $value) use ($valueInFilter) {
            return $value == $valueInFilter;
        }));
    }

	private function uploadImage($request, $isbn, $imageUrl)
	{
		if ($request->hasFile('image')) {
        	$fileName = $isbn . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalName();
        	if ($request->file('image')->isValid()) {
        		$request->file('image')->move(public_path() . '/storage/', $fileName);
        		return $fileName;
        	}
        }
        return $imageUrl;
	}

	/**
	 * Display the specified resource.
	 * GET /books/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$breaks = array("<br />","<br>","<br/>"); 
        $book = $this->book->with('authors', 'categories')->findOrFail($id);

        $book->description = str_ireplace($breaks, "<br>", $book->description);
        $book->genres = implode('<br>', $this->reformatCategories($book->categories->toArray(), true));
        $book->author = implode("; ", $this->reformatCategories($book->authors->toArray(), true));

        $url = $book->imageUrl;
        if (!str_contains($url, 'no_book_cover.jpg') && !str_contains($url, 'http')) {
            $url = '/storage/' . $url; 
        } elseif (!str_contains($url, 'http')) {
            $url = '/images/no_book_cover.jpg';
        }
        $book->image = HTML::image($url, null, array('height' => '300px'));

        return View::make('books.show')->with('book', $book);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /books/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data = array(
			'genres' => $this->reformatGenres($this->category->select('id','name')->get()->toArray()),
			'book' => $this->book->with('authors', 'categories')->where('id', '=', $id)->firstOrFail()
			);
		$data['book']->genres = $this->reformatCategories($data['book']->categories->toArray());
		$data['book']->author = implode("; ", $this->reformatCategories($data['book']->authors->toArray(), true));
        $data['book']->description = preg_replace('#<br\s*/?>#i', "\n", $data['book']->description);
        return View::make("books.edit")->with($data);
	}

	private function reformatCategories($cat, $nameOnly = false)
	{
		$result = array();
		foreach ($cat as $val) {
			if ($nameOnly) {
				$result[] = $val['name'];
			} else {
				$result[] = $val['id'];
			}
		}
		return $result;
	}

	private function reformatGenres($genres)
	{
		$result = array();
		foreach ($genres as $value) {
			$id = 0;
			foreach ($value as $key => $val) {
				if ($key == "id") {
					$id = $val;
				} else {
					$result[lcfirst($id)] = ucfirst($val);
				}
			}
		}
		return $result;
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /books/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		return $this->saveBookInfo($request, $id, true);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /books/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = $this->book->find($id);
		$book->delete();
		return Redirect::route('admin.books.index');
	}

}