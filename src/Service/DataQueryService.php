<?php
namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class DataQueryService
{
	private $request;
	private $userRepository;

	public function __construct(RequestStack $request, UserRepository $userRepository)
	{
		$this->request = $request;
		$this->userRepository = $userRepository;
	}

	/**
	 * Get users based on a search
	 *
	 * @return array
	 */
	public function search()
	{	
		if($this->request->getCurrentRequest()->query->has('search')) {
			$search = $this->request->getCurrentRequest()->query->get('search');
			return $search;
		}
	}

	/**
	 * filled the orderBy parameter with the "sort" parameter if it exists in the url
	 *
	 * @return array
	 */
	public function orderBy()
	{
		$orderBy = [
			"sort" => null,
			"order" => null
		];
		$validColumns = ['licenceNumber', 'firstname', 'lastname']; // Whitelist of allowed columns
		$validOrders = ['asc', 'desc']; // Whitelist of allowed orders
		
		// get the result of search request in url (/users?sort=[string])
		if ($this->request->getCurrentRequest()->query->has('sort')) {
			
			$sort = $this->request->getCurrentRequest()->query->get('sort');
			if(in_array($sort, $validColumns)){
				$orderBy["sort"] = $sort;
			} else {
				return "error";
			}
		}
		if ($this->request->getCurrentRequest()->query->has('order')) {
			
			$order = $this->request->getCurrentRequest()->query->get('order');
			if(in_array($order, $validOrders)){
				$orderBy["order"] = $order;
			} else {
				return "error";
			}
		}
		return $orderBy;
	}

	/**
	 * Get all users of one page, the number of pages and the current page
	 * 
	 * @return array 
	 */
	public function getUsersOfOnePage()
	{
		// get the page number in url (/users?page=[int])
		$page = (int) $this->request->getCurrentRequest()->query->get('page', 1);
		if($page < 1){
			$page = 1;
		}
		//sets the number of users to display on the page
		$limit = 10;
		//sets the number of users of previous pages not to be retrieved
		$offset = ($page - 1) * $limit;

		if($this->orderBy() === "error"){
			return $this->orderBy();
		} else {
		$users = $this->userRepository->searchUsers($this->search(), $this->orderBy()["sort"], $this->orderBy()["order"] , $limit, $offset);
		$nbPages = ceil($this->getNumberOfUsers() / $limit);
		
		return ["users" => $users, "currentPage" => $page, "nbPages" => $nbPages];
			}
	}

	/**
	 * get the number of users to display
	 *
	 * @return int number of users
	 */
	public function getNumberOfUsers()
	{
		return count($this->userRepository->searchUsers($this->search(), $this->orderBy()["sort"], $this->orderBy()["order"], null, null));
		
	}
	
}