<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 19.03.19
 * Time: 10:46
 */

namespace App\Entry;

use App\Core\AbstractController;
use App\Core\PaginationService;
use App\User\LoginService;

class EntryController extends AbstractController
{
    public function __construct(EntryRepository $entryRepository, LoginService $loginService, PaginationService $paginationService)
    {
        $this->entryRepository = $entryRepository;
        $this->loginService = $loginService;
        $this->paginationService = $paginationService;
    }

    /*
     *  - retrieve all necessary data
     *  - calls render function for pagination and entries and navigation
     */
    public function index()
    {
        /*
         * find if filter is set
         */
        if(isset($_GET['author']))
        {
            $author = $_GET['author'];
        }
        else
        {
            $author = "";
        }

        /*
         * get pagination containing entries filtered by page and author
         */
        $pagination = $this->paginationService->getPagination($author);

        /*
         * get all authors for filter
         */
        $authors = $this->entryRepository->getAuthors();

        /*
         * call render function for navigation bar
         */
        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);

        /*
         * call render function for pagination if there is more than one page
         */
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
        $this->render("layout/authorSearch",[
            'authors' => $authors
        ]);
        $this->render("Entries/index", [
            'entries' => $pagination['entries']
        ]);
        if($pagination['numPages']>1)
        {
            $this->render("layout/pagination", [
                'numPages' => $pagination['numPages']
            ]);
        }
    }

    /*
     *  - retrieve entry id from url
     *  - call render function with entry
     */
    public function singleEntry()
    {
        $id = $_GET['eid'];
        $entry = $this->entryRepository->findById($id);
        $this->render("layout/header", [
            'navigation' => $this->loginService->getNavigation()
        ]);
        $this->render("Entries/singleEntry", [
            'entry' => $entry
        ]);
    }
}