<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url'));
		$this->load->model('modelcategory');
		$this->load->model('modelproject');
	}

	public function index()
	{
		$data = array(
				'title' => 'Subianto & Siane Architecture - Project',
				'projectactlink' => 'act-link',
				'loadcategorycount' => $this->modelcategory->loadCategoryCount(),
				'loadallproject' => $this->modelproject->loadAllProject()
			);
		$this->load->view('public/project', $data);
	}

	public function filter()
	{
		$uri3 = $this->uri->segment(3);
		$checkcategory = $this->modelproject->checkProjectbyFilter($uri3);
		if($checkcategory->num_rows() > 0){
			$data = array(
				'title' => 'Subianto & Siane Architecture - Project',
				'projectactlink' => 'act-link',
				'loadcategorycount' => $this->modelcategory->loadCategoryCount(),
				'loadallproject' => $this->modelproject->loadAllProject(),
				'filter' => strtolower($uri3)
			);
			$this->load->view('public/project', $data);
		}else{
			redirect('project/');
			// echo '404 not found';
		}
	}

	public function detail()
	{
		$projecturi = $this->uri->segment(3);
		$checkprojectdetail = $this->modelproject->checkProjectDetail($projecturi);
		if($checkprojectdetail->num_rows() > 0){
			$p = $this->getprevproject($projecturi);
			$n = $this->getnextproject($projecturi);
			if($p!=''){
				$prev = $p->project_uri;
			}else{
				$prev = '';
			}
			if($n!=''){
				$next = $n->project_uri;
			}else{
				$next = '';
			}

			$data = array(
				'title' => 'Subianto & Siane Architecture - Project Detail',
				'projectactlink' => 'act-link',
				'loadoneproject' => $this->modelproject->loadOneProject($projecturi),
				'loadallphotosdetailproject' => $this->modelproject->loadAllPhotosDetailProject($projecturi),
				'prev' => $prev,
				'next' => $next
			);
			$this->load->view('public/project_detail', $data);	
		}else{
			redirect('project/');
		}
	}

	function getprevproject($currentproject)
	{
		$prevpost = '';
		$currentpost = 0;

		$all = $this->modelproject->loadAllProject();

		$sizeofAll = count($all);

		$counter = 1;
		foreach ($all as $a) {
			$uriproject = $a->project_uri;
 			if($uriproject == $currentproject){
 				$currentpost = $counter;
 			}
 			$counter++;
		}
		// echo count($all);
		// echo $currentpost;
		if($currentpost == '1' || $sizeofAll == '1'){
			$prevpost = '';
		}else{
			$currentinArray = $currentpost-1;
			$prev = $currentinArray-1;
			$prevpost = $all[$prev];
		}
		// print_r($prevpost);
		return $prevpost;
	}

	function getnextproject($currentproject)
	{
		$nextpost = '';
		$currentpost = 0;

		$all = $this->modelproject->loadAllProject();

		$sizeofAll = count($all);
		$counter = 1;
		foreach ($all as $a) {
			$uriproject = $a->project_uri;
 			if($uriproject == $currentproject){
 				$currentpost = $counter;
 			}
 			$counter++;
		}
		if($currentpost == $sizeofAll || $sizeofAll == '1'){
			$nextpost = '';
		}else{
			$currentinArray = $currentpost - 1;
			$next = $currentinArray+1;
			$nextpost = $all[$next];
		}
		// print_r($nextpost);
		return $nextpost;
	}

}

/* End of file project.php */
/* Location: ./application/controllers/project.php */