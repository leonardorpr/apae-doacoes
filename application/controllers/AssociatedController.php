<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AssociatedController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('AssociatedModel');
  }

  public function index() {
    $baseUrl = base_url('associated');
    $totalRows = $this->AssociatedModel->totalCount();
    $perPage = 5;

    $getPage = (int) $this->input->get("page");
    $page = $getPage == 0 ? $getPage : ($getPage-1)*$perPage;

    $data['associated'] = $this->AssociatedModel->getAll($perPage, $page);
    $config = PaginationHelper($baseUrl, $totalRows, $perPage);
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    $this->template->load('template', 'associated/listAssociated', $data);
  }

  public function newAssociate() {
    $data['contact_types'] = $this->AssociatedModel->getAllContactTypes();

    if ($this->session->contact_types) {
      $data['contact_types'] = $this->AssociatedModel->getAllContactTypes();
      $this->session->set_userdata('contact_types', $data['contact_types']);
    }
    $data['action'] = 'associated/create';
    $data['title'] = 'Novo Associado';
    $this->template->load('template', 'associated/createAssociated', $data);
  }

  public function createAssociate() {
    $this->form_validation->set_rules('name_associate', 'Nome', 'required');
    $this->form_validation->set_rules('rg', 'RG', 'required');
    $this->form_validation->set_rules('cpf', 'CPF', 'required');
    $this->form_validation->set_rules('birth_date', 'Data de Nascimento', 'required');

    if ($this->form_validation->run()) {
      $associate = $this->input->post();
      $id = $this->AssociatedModel->create($associate);
      if($id !== 0){
        redirect('associated-detail/'.$id,'refresh');
      }else{
        redirect('associated','refresh');
      }

    }else {
      $data['contact_types'] = $this->AssociatedModel->getAllContactTypes();
      $data['action'] = 'associated/create';
      $data['title'] = 'Novo Associado';
      $this->template->load('template', 'associated/createAssociated', $data);
    }
  }

  public function detailedAssociate() {
    $id = $this->uri->segment(2);
    $data['associate'] = $this->AssociatedModel->getById($id)[0];
    $this->template->load('template', 'associated/detailedAssociated', $data);
  }

  public function editAssociate() {
    $id = $this->uri->segment(3);
    $data['title'] = "Alterar Associado";
    $data['contact_types'] = $this->AssociatedModel->getAllContactTypes();
    $data['user_contacts'] = $this->AssociatedModel->getUserContacts($id);
    $data['action'] = "associated/update";
    $data['associate'] = $this->AssociatedModel->getById($id)[0];
    $this->template->load('template', 'associated/updateAssociated', $data);
  }

  public function updateAssociate() {
    $this->form_validation->set_rules('name_associate', 'Nome', 'required');
    $this->form_validation->set_rules('rg', 'RG', 'required');
    $this->form_validation->set_rules('cpf', 'CPF', 'required');
    $this->form_validation->set_rules('birth_date', 'Data de Nascimento', 'required');

    if ($this->form_validation->run()) {
      $associate = array(
        'id_associate' => $this->input->post('id_associate'),
        'name_associate' => $this->input->post('name_associate'),
        'rg' => $this->input->post('rg'),
        'cpf' => $this->input->post('cpf'),
        'birth_date' => $this->input->post('birth_date'),
        'street' => $this->input->post('street'),
        'number' => $this->input->post('number'),
        'neighborhood' => $this->input->post('neighborhood')
        );
      $contacts = $this->input->post('contact');

      if ($this->AssociatedModel->update($associate,$contacts)) {
        redirect('associated', 'refresh');
      }else{
        redirect('associated','refresh');
      }
    }
    else {
      $data['title'] = "Alterar Associado";
      $data['action'] = "associated/update";
      $data['contact_types'] = $this->AssociatedModel->getAllContactTypes();
      $data['user_contacts'] = $this->AssociatedModel->getUserContacts($this->input->post('id_associate'));
      $this->template->load('template', 'associated/updateAssociated', $data);
    }
  }

  public function deleteAssociate() {
    $id = $this->uri->segment(3);
    $this->AssociatedModel->delete($id);
    redirect('associated','refresh');
  }

  public function inactiveAssociate() {
    $id = $this->uri->segment(3);
    $this->AssociatedModel->inactive($id);
  }

  public function dialogContact() {
    $this->load->view('associated/dialogContact');
  }

}