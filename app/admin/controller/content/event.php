<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace Admin\Controller\Content;
use Dais\Engine\Controller;

class Event extends Controller {
    
    private $error = array();
    
    public function index() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        $this->getList();
    }
    
    public function insert() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            $this->model_content_event->addEvent($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_add_success');
            $this->response->redirect($this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->getForm();
    }
    
    public function update() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            $this->model_content_event->editEvent($this->request->get['event_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_edit_success');
            $this->response->redirect($this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->getForm();
    }
    
    public function delete() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (isset($this->request->post['selected']) && $this->validateDelete()):
            foreach ($this->request->post['selected'] as $event_id):
                $this->model_content_event->deleteEvent($event_id);
            endforeach;
            $this->session->data['success'] = $this->language->get('lang_text_delete_success');
            $this->response->redirect($this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->getList();
    }
    
    public function insert_presenter() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormPresenter()):
            $this->model_content_event->addPresenter($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_add_i_success');
            $this->response->redirect($this->url->link('content/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->presenter_form();
    }
    
    public function update_presenter() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormPresenter()):
            $this->model_content_event->editPresenter($this->request->get['presenter_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_edit_i_success');
            $this->response->redirect($this->url->link('content/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->presenter_form();
    }
    
    public function delete_presenter() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        if (isset($this->request->post['selected']) && $this->validateDeletePresenter()):
            foreach ($this->request->post['selected'] as $presenter_id):
                $this->model_content_event->deletePresenter($presenter_id);
            endforeach;
            $this->session->data['success'] = $this->language->get('lang_text_delete_i_success');
            $this->response->redirect($this->url->link('content/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        $this->presenter_list();
    }
    
    public function add_to_wait_list() {
        $this->theme->language('content/event');
        $this->theme->model('content/event');
        $json = array();
        $results = $this->model_content_event->addToWaitList($this->request->post);
        if ($results == 1):
            $success = 1;
            $message = $this->language->get('lang_text_add_waitlist_success');
        elseif ($results == 0):
            $success = 0;
            $message = $this->language->get('lang_text_duplicate_attendee');
        else:
            $success = 0;
            $message = $this->language->get('lang_error_attendee_exists');
        endif;
        $json = array('success' => $success, 'message' => $message);
        $this->response->setOutput(json_encode($json));
    }
    
    public function insert_attendee() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        $json = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRoster()):
            $exists = $this->model_content_event->checkAttendee($this->request->post);
            if (!$exists):
                $this->model_content_event->addAttendee($this->request->post);
                $results     = $this->model_content_event->getRoster($this->request->post['event_id']);
                $roster_html = '';
                if ($results):
                    foreach ($results as $result):
                        $roster_html .= '<tr>';
                        $roster_html .= '<td class="text-center">';
                        $roster_html .= '<input type="checkbox" name="selected[]" value="' . $result['attendee_id'] . '" />';
                        $roster_html .= '</td>';
                        $roster_html .= '<td>' . $result['name'] . '</td>';
                        $roster_html .= '<td class="text-right">' . date($this->language->get('lang_date_format_short'), $result['date_added']) . '</td>';
                        $roster_html .= '</tr>';
                    endforeach;
                else:
                    $roster_html .= '<tr>';
                    $roster_html .= '<td class="text-center" colspan="3">' . $this->language->get('lang_text_no_attendees') . '</td>';
                    $roster_html .= '</tr>';
                endif;
                $available = $this->model_content_event->getAvailable($this->request->post['event_id']);
                $json = array(
                    'success'   => 1, 
                    'message'   => $this->language->get('lang_text_add_s_success'), 
                    'roster'    => $roster_html, 
                    'available' => $available
                );
            else:
                $json = array(
                    'success' => 0, 
                    'message' => $this->language->get('lang_error_attendee_exists')
                );
            endif;
        endif;
        $this->response->setOutput(json_encode($json));
    }
    
    public function delete_attendee() {
        $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        
        if (isset($this->request->post['selected']) && $this->validateRoster()):
            $a = 0;
            foreach ($this->request->post['selected'] as $attendee_id):
                $this->model_content_event->deleteAttendee($this->request->get['event_id'], $attendee_id);
                $a++;
            endforeach;
            $this->model_content_event->updateSeats($this->request->get['event_id'], $a);
            $this->session->data['success'] = $this->language->get('lang_text_delete_s_success');
            $this->response->redirect($this->url->link('content/event/roster', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'], 'SSL'));
        endif;
        $this->roster();
    }
    
    public function get_wait_list() {
        $data = $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_column_waitlist'));
        $this->theme->model('content/event');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        elseif (isset($this->session->data['error_warning'])):
            $data['error_warning'] = $this->session->data['error_warning'];
            unset($this->session->data['error_warning']);
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        $this->breadcrumb->add('lang_column_waitlist', 'content/event/get_wait_list', '&event_id=' . $this->request->get['event_id']);
        
        $results = $this->model_content_event->getWaitListAttendees($this->request->get['event_id']);
        
        $data['attendees'] = array();
        
        if ($results):
            foreach ($results as $result):
                $actions = array();
                $actions[] = array(
                    'text' => $this->language->get('lang_text_add'), 
                    'href' => $this->url->link('content/event/add_to_event', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'] . '&customer_id=' . $result['customer_id'], 'SSL')
                );
                $actions[] = array(
                    'text' => $this->language->get('lang_text_remove'), 
                    'href' => $this->url->link('content/event/remove_from_list', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'] . '&event_wait_list_id=' . $result['event_wait_list_id'], 'SSL')
                );
                
                $this->theme->model('people/customer');
                
                $customer_info = $this->model_people_customer->getCustomer($result['customer_id']);
                
                $data['attendees'][] = array(
                    'event_wait_list_id' => $result['event_wait_list_id'], 
                    'event_id'           => $result['event_id'], 
                    'attendee'           => $customer_info['firstname'] . ' ' . $customer_info['lastname'] . ' (' . $customer_info['username'] . ')', 
                    'action'             => $actions
                );
            endforeach;
        endif;
        
        $data['token']      = $this->session->data['token'];
        $data['clear_list'] = $this->url->link('content/event/empty_wait_list', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'], 'SSL');
        $data['cancel']     = $this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/waitlist', $data));
    }
    
    public function add_to_event() {
        $this->theme->language('content/event');
        $this->theme->model('content/event');
        $this->model_content_event->addToEvent($this->request->get);
        $this->session->data['success'] = $this->language->get('lang_text_add_to_event');
        $this->response->redirect($this->url->link('content/event/get_wait_list', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'], 'SSL'));
    }
    
    public function remove_from_list() {
        $this->theme->language('content/event');
        $this->theme->model('content/event');
        $this->model_content_event->removeFromList($this->request->get['event_wait_list_id']);
        $this->session->data['success'] = $this->language->get('lang_text_remove_from_list');
        $this->response->redirect($this->url->link('content/event/get_wait_list', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'], 'SSL'));
    }
    
    public function empty_wait_list() {
        $this->theme->model('content/event');
        $this->model_content_event->emptyWaitList($this->request->get['event_id']);
        $this->response->redirect($this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL'));
    }
    
    public function getList() {
        $data = $this->theme->language('content/event');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        elseif (isset($this->session->data['error_warning'])):
            $data['error_warning'] = $this->session->data['error_warning'];
            unset($this->session->data['error_warning']);
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        
        $filter  = array();
        $results = $this->model_content_event->getEvents($filter);
        
        $data['events'] = array();
        
        $this->theme->model('people/customergroup');
        
        if ($results):
            foreach ($results as $result):
                $actions = array();
                
                $actions[] = array(
                    'text' => $this->language->get('lang_text_edit'), 
                    'href' => $this->url->link('content/event/update', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'], 'SSL')
                );
                
                $actions[] = array(
                    'text' => $this->language->get('lang_text_roster'), 
                    'href' => $this->url->link('content/event/roster', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'], 'SSL')
                );
                
                if ($result['link']):
                    $location = $this->language->get('lang_text_link');
                else:
                    $location = nl2br($result['location']);
                endif;
                
                $data['events'][] = array(
                    'event_id'      => $result['event_id'], 
                    'event_name'    => html_entity_decode($result['event_name']), 
                    'visibility'    => $this->model_people_customergroup->getCustomerGroupName($result['visibility']), 
                    'date_time'     => date($this->language->get('lang_date_format_short') . ' ' . $this->language->get('lang_time_format'), strtotime($result['date_time'])), 
                    'location'      => $location, 
                    'cost'          => $this->currency->format($result['cost']), 
                    'seats'         => $result['seats'], 
                    'filled'        => $result['seats'] - $result['filled'], 
                    'waitlist'      => $this->model_content_event->getWaitListCount($result['event_id']), 
                    'waitlist_href' => $this->url->link('content/event/get_wait_list', 'token=' . $this->session->data['token'] . '&event_id=' . $result['event_id'], 'SSL'), 
                    'presenter'     => $this->model_content_event->getPresenterName($result['presenter_id']), 
                    'selected'      => isset($this->request->post['selected']) && in_array($result['result_id'], $this->request->post['selected']), 
                    'action'        => $actions
                );
            endforeach;
        endif;
        
        $data['token']      = $this->session->data['token'];
        $data['presenters'] = $this->url->link('content/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL');
        $data['insert']     = $this->url->link('content/event/insert', 'token=' . $this->session->data['token'], 'SSL');
        $data['delete']     = $this->url->link('content/event/delete', 'token=' . $this->session->data['token'], 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/event_list', $data));
    }
    
    public function getForm() {
        $data = $this->theme->language('content/event');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }
        
        if (isset($this->error['model'])) {
            $data['error_model'] = $this->error['model'];
        } else {
            $data['error_model'] = array();
        }
        
        if (isset($this->error['event_length'])) {
            $data['error_event_length'] = $this->error['event_length'];
        } else {
            $data['error_event_length'] = array();
        }
        
        if (isset($this->error['event_days'])) {
            $data['error_event_days'] = $this->error['event_days'];
        } else {
            $data['error_event_days'] = '';
        }
        
        if (isset($this->error['event_date'])) {
            $data['error_event_date'] = $this->error['event_date'];
        } else {
            $data['error_event_date'] = '';
        }
        
        if (isset($this->error['event_time'])) {
            $data['error_event_time'] = $this->error['event_time'];
        } else {
            $data['error_event_time'] = '';
        }
        
        if (isset($this->error['location'])) {
            $data['error_location'] = $this->error['location'];
        } else {
            $data['error_location'] = '';
        }
        
        if (isset($this->error['link'])) {
            $data['error_link'] = $this->error['link'];
        } else {
            $data['error_link'] = '';
        }
        
        if (isset($this->error['cost'])) {
            $data['error_cost'] = $this->error['cost'];
        } else {
            $data['error_cost'] = '';
        }
        
        if (isset($this->error['seats'])) {
            $data['error_seats'] = $this->error['seats'];
        } else {
            $data['error_seats'] = '';
        }
        
        if (isset($this->error['presenter'])) {
            $data['error_presenter'] = $this->error['presenter'];
        } else {
            $data['error_presenter'] = '';
        }
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = '';
        }
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = '';
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        
        if (!isset($this->request->get['event_id'])) {
            $data['action'] = $this->url->link('content/event/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $data['action'] = $this->url->link('content/event/update', 'token=' . $this->session->data['token'] . '&event_id=' . $this->request->get['event_id'], 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['event_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $event_info = $this->model_content_event->getEvent($this->request->get['event_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        $data['days']  = array(
            $this->language->get('lang_text_monday'), 
            $this->language->get('lang_text_tuesday'), 
            $this->language->get('lang_text_wednesday'), 
            $this->language->get('lang_text_thursday'), 
            $this->language->get('lang_text_friday'), 
            $this->language->get('lang_text_saturday'), 
            $this->language->get('lang_text_sunday')
        );
        
        $this->theme->model('catalog/product');
        
        $product_info = array();
        
        if (!empty($event_info)) {
            $product_info = $this->model_catalog_product->getProduct($event_info['product_id']);
        }
        
        if (isset($this->request->post['name'])) {
            $data['name'] = html_entity_decode($this->request->post['name']);
        } elseif (!empty($event_info)) {
            $data['name'] = html_entity_decode($event_info['event_name']);
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['product_id'])) {
            $data['product_id'] = $this->request->post['product_id'];
        } elseif (!empty($event_info)) {
            $data['product_id'] = $event_info['product_id'];
        } else {
            $data['product_id'] = 0;
        }

        if (isset($this->request->post['model'])) {
            $data['model'] = html_entity_decode($this->request->post['model']);
        } elseif (!empty($event_info)) {
            $data['model'] = html_entity_decode($event_info['model']);
        } else {
            $data['model'] = '';
        }
        
        if (isset($this->request->post['sku'])) {
            $data['sku'] = html_entity_decode($this->request->post['sku']);
        } elseif (!empty($product_info)) {
            $this->theme->test($product_info);
            $data['sku'] = html_entity_decode($product_info['sku']);
        } else {
            $data['sku'] = '';
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['product_store'])) {
            $data['product_store'] = $this->request->post['product_store'];
        } elseif (!empty($event_info)) {
            $data['product_store'] = $this->model_catalog_product->getProductStores($data['product_id']);
        } else {
            $data['product_store'] = array(0);
        }
        
        $this->theme->model('localization/stock_status');
        
        $data['stock_statuses'] = $this->model_localization_stock_status->getStockStatuses();
        
        if (isset($this->request->post['stock_status_id'])) {
            $data['stock_status_id'] = $this->request->post['stock_status_id'];
        } elseif (!empty($product_info)) {
            $data['stock_status_id'] = $product_info['stock_status_id'];
        } else {
            $data['stock_status_id'] = $this->config->get('config_stock_status_id');
        }
        
        $this->theme->model('catalog/category');
        
        $filter = array();
        
        $data['categories'] = $this->model_catalog_category->getCategories($filter);
        
        if (isset($this->request->post['product_category'])) {
            $data['product_category'] = $this->request->post['product_category'];
        } elseif (!empty($event_info)) {
            $data['product_category'] = $this->model_catalog_product->getProductCategories($data['product_id']);
        } else {
            $data['product_category'] = array();
        }
        
        if (isset($this->request->post['visibility'])) {
            $data['visibility'] = $this->request->post['visibility'];
        } elseif (!empty($event_info)) {
            $data['visibility'] = $event_info['visibility'];
        } else {
            $data['visibility'] = '';
        }
        
        $this->theme->model('people/customergroup');
        
        $data['customer_groups'] = $this->model_people_customergroup->getCustomerGroups();
        
        if (isset($this->request->post['event_length'])) {
            $data['event_length'] = $this->request->post['event_length'];
        } elseif (!empty($event_info)) {
            $data['event_length'] = $event_info['event_length'];
        } else {
            $data['event_length'] = 1;
        }
        
        if (isset($this->request->post['event_days'])) {
            $data['event_days'] = $this->request->post['event_days'];
        } elseif (!empty($event_info)) {
            $data['event_days'] = unserialize($event_info['event_days']);
        } else {
            $data['event_days'] = array();
        }
        
        if (isset($this->request->post['event_date'])) {
            $data['event_date'] = $this->request->post['event_date'];
        } elseif (!empty($event_info)) {
            $data['event_date'] = date('Y-m-d', strtotime($event_info['date_time']));
        } else {
            $data['event_date'] = '';
        }
        
        if (isset($this->request->post['event_time'])) {
            $data['event_time'] = $this->request->post['event_time'];
        } elseif (!empty($event_info)) {
            $data['event_time'] = date('g:i A', strtotime($event_info['date_time']));
        } else {
            $data['event_time'] = '';
        }
        
        if (isset($this->request->post['location'])) {
            $data['location'] = $this->request->post['location'];
        } elseif (!empty($event_info)) {
            $data['location'] = $event_info['location'];
        } else {
            $data['location'] = '';
        }
        
        if (isset($this->request->post['online'])) {
            $data['online'] = $this->request->post['online'];
        } elseif (!empty($event_info)) {
            $data['online'] = $event_info['online'];
        } else {
            $data['online'] = '';
        }
        
        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        } elseif (!empty($event_info)) {
            $data['link'] = $event_info['link'];
        } else {
            $data['link'] = '';
        }
        
        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } elseif (!empty($event_info)) {
            $data['telephone'] = $event_info['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        if (isset($this->request->post['cost'])) {
            $data['cost'] = $this->request->post['cost'];
        } elseif (!empty($event_info)) {
            $data['cost'] = $event_info['cost'];
        } else {
            $data['cost'] = '';
        }
        
        if (isset($this->request->post['seats'])) {
            $data['seats'] = $this->request->post['seats'];
        } elseif (!empty($event_info)) {
            $data['seats'] = $event_info['seats'];
        } else {
            $data['seats'] = '';
        }
        
        if (isset($this->request->post['presenter_tab'])) {
            $data['presenter_tab'] = $this->request->post['presenter_tab'];
        } elseif (!empty($event_info)) {
            $data['presenter_tab'] = $event_info['presenter_tab'];
        } else {
            $data['presenter_tab'] = '';
        }
        
        if (isset($this->request->post['presenter'])) {
            $data['presenter'] = $this->request->post['presenter'];
        } elseif (!empty($event_info)) {
            $data['presenter'] = $event_info['presenter_id'];
        } else {
            $data['presenter'] = '';
        }
        
        if (isset($this->request->post['description'])) {
            $data['description'] = html_entity_decode($this->request->post['description']);
        } elseif (!empty($event_info)) {
            $data['description'] = html_entity_decode($event_info['description']);
        } else {
            $data['description'] = '';
        }
        
        if (isset($this->request->post['refundable'])) {
            $data['refundable'] = $this->request->post['refundable'];
        } elseif (!empty($event_info)) {
            $data['refundable'] = $event_info['refundable'];
        } else {
            $data['refundable'] = '';
        }

        if (isset($this->request->post['is_product'])) {
            $data['is_product'] = $this->request->post['is_product'];
        } elseif (!empty($event_info) && (int)$event_info['product_id'] > 0) {
            $data['is_product'] = 1;
        } else {
            $data['is_product'] = 0;
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($product_info)) {
            $data['slug'] = $product_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($product_info)) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        $data['presenters'] = $this->model_content_event->getPresenters();
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/event_form', $data));
    }
    
    public function presenter_list() {
        $data = $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/event');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } elseif (isset($this->session->data['error_warning'])) {
            $data['error_warning'] = $this->session->data['error_warning'];
            unset($this->session->data['error_warning']);
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        $this->breadcrumb->add('lang_text_presenter_tab', 'content/event/presenter_list');
        
        $filter = array();
        
        $results = $this->model_content_event->getPresenters($filter);
        
        $data['presenters'] = array();
        
        if ($results) {
            foreach ($results as $result) {
                $action = array();
                
                $action[] = array(
                    'text' => $this->language->get('lang_text_edit'), 
                    'href' => $this->url->link('content/event/update_presenter', 'token=' . $this->session->data['token'] . '&presenter_id=' . $result['presenter_id'], 'SSL')
                );
                
                $data['presenters'][] = array(
                    'presenter_id'   => $result['presenter_id'], 
                    'presenter_name' => $result['presenter_name'], 
                    'bio'            => html_entity_decode($result['bio']), 
                    'action'         => $action
                );
            }
        }
        
        $data['token']  = $this->session->data['token'];
        $data['insert'] = $this->url->link('content/event/insert_presenter', 'token=' . $this->session->data['token'], 'SSL');
        $data['delete'] = $this->url->link('content/event/delete_presenter', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/presenter_list', $data));
    }
    
    public function presenter_form() {
        $data = $this->theme->language('content/event');
        $this->theme->model('content/event');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['presenter_name'])) {
            $data['error_presenter_name'] = $this->error['presenter_name'];
        } else {
            $data['error_presenter_name'] = array();
        }
        
        if (isset($this->error['bio'])) {
            $data['error_bio'] = $this->error['bio'];
        } else {
            $data['error_bio'] = array();
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        $this->breadcrumb->add('lang_text_presenter_tab', 'content/event/presenter_list');
        
        if (!isset($this->request->get['presenter_id'])) {
            $data['action'] = $this->url->link('content/event/insert_presenter', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $data['action'] = $this->url->link('content/event/update_presenter', 'token=' . $this->session->data['token'] . '&presenter_id=' . $this->request->get['presenter_id'], 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['presenter_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $event_info = $this->model_content_event->getPresenter($this->request->get['presenter_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['presenter_name'])) {
            $data['presenter_name'] = $this->request->post['presenter_name'];
        } elseif (!empty($event_info)) {
            $data['presenter_name'] = $event_info['presenter_name'];
        } else {
            $data['presenter_name'] = '';
        }
        
        if (isset($this->request->post['bio'])) {
            $data['bio'] = $this->request->post['bio'];
        } elseif (!empty($event_info)) {
            $data['bio'] = $event_info['bio'];
        } else {
            $data['bio'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/presenter_form', $data));
    }
    
    public function roster() {
        $data = $this->theme->language('content/event');
        $this->theme->setTitle($this->language->get('lang_text_roster'));
        $this->theme->model('content/event');
        
        if (isset($this->request->post['event_id'])) {
            $event_id = $this->request->post['event_id'];
        } elseif (isset($this->request->get['event_id'])) {
            $event_id = $this->request->get['event_id'];
        } else {
            $event_id = '';
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/event');
        $this->breadcrumb->add('lang_text_roster', 'content/event/roster', '&event_id=' . $this->request->get['event_id']);
        
        $this->theme->model('people/customer');
        
        $data['customers'] = $this->model_people_customer->getCustomers();
        
        $data['attendees'] = array();
        
        $results = $this->model_content_event->getRoster($event_id);
        
        if ($results) {
            foreach ($results as $result) {
                $data['attendees'][] = array(
                    'attendee_id' => $result['attendee_id'], 
                    'name'        => $this->model_content_event->getAttendeeName($result['attendee_id']), 
                    'date_added'  => date($this->language->get('lang_date_format_short'), $result['date_added'])
                );
            }
        }
        
        $data['event_name'] = $this->model_content_event->getEventName($event_id);
        $data['seats']      = $this->model_content_event->getSeats($event_id);
        $data['available']  = $this->model_content_event->getAvailable($event_id);
        $data['event_id']   = $event_id;
        $data['delete']     = $this->url->link('content/event/delete_attendee', 'token=' . $this->session->data['token'] . '&event_id=' . $event_id, 'SSL');
        $data['cancel']     = $this->url->link('content/event', 'token=' . $this->session->data['token'], 'SSL');
        $data['token']      = $this->session->data['token'];
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->loadjs('javascript/content/roster', $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/roster', $data));
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['name'])) {
            $this->theme->model('people/customer');
            
            $filter = array('filter_username' => $this->request->get['name'], 'start' => 0, 'limit' => 20);
            
            $results = $this->model_people_customer->getCustomers($filter);
            
            foreach ($results as $result) {
                $json[] = array(
                    'attendee_id' => $result['customer_id'], 
                    'name'        => strip_tags(html_entity_decode($result['username'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    private function validateForm() {
        $this->theme->language('content/event');
        
        if (!$this->user->hasPermission('modify', 'content/event')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 1) || ($this->encode->strlen($this->request->post['name']) > 150)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if ($this->request->post['slug'] == "") {
            $this->error['slug'] = $this->language->get('lang_error_slug');
        }
        
        if ($this->request->post['is_product']):
            if (($this->encode->strlen($this->request->post['model']) < 1) || ($this->encode->strlen($this->request->post['model']) > 50)):
                $this->error['model'] = $this->language->get('lang_error_model');
            endif;
        endif;
        
        if (($this->encode->strlen($this->request->post['event_length']) < 1) || ($this->encode->strlen($this->request->post['event_length']) > 40)) {
            $this->error['event_length'] = $this->language->get('lang_error_event_length');
        }
        
        if ($this->request->post['event_date'] == "" || date('Y-m-d', time()) >= date('Y-m-d', strtotime($this->request->post['event_date']))) {
            $this->error['event_date'] = $this->language->get('lang_error_event_date');
        }
        
        if ($this->request->post['event_time'] == "") {
            $this->error['event_time'] = $this->language->get('lang_error_event_time');
        }
        
        if ($this->request->post['online']):
            if ($this->encode->strlen($this->request->post['link']) < 1):
                $this->error['link'] = $this->language->get('lang_error_link');
            endif;
        else:
            if (($this->encode->strlen($this->request->post['location']) < 1) || ($this->encode->strlen($this->request->post['location']) > 200)) {
                $this->error['location'] = $this->language->get('lang_error_location');
            }
        endif;
        
        if (!isset($this->request->post['event_days'])) {
            $this->error['event_days'] = $this->language->get('lang_error_event_days');
        }
        
        if ($this->request->post['cost'] == "") {
            $this->error['cost'] = $this->language->get('lang_error_cost');
        }
        
        if ($this->request->post['seats'] == "") {
            $this->error['seats'] = $this->language->get('lang_error_seats');
        }
        
        if ($this->encode->strlen($this->request->post['description']) < 25) {
            $this->error['description'] = $this->language->get('lang_error_description');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'content/event')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        return !$this->error;
    }
    
    private function validateFormPresenter() {
        if (!$this->user->hasPermission('modify', 'content/event')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        if (($this->encode->strlen($this->request->post['presenter_name']) < 1) || ($this->encode->strlen($this->request->post['presenter_name']) > 150)) {
            $this->error['presenter_name'] = $this->language->get('lang_error_presenter_name');
        }
        
        if ($this->encode->strlen($this->request->post['bio']) < 25) {
            $this->error['bio'] = $this->language->get('lang_error_bio');
        }
        
        return !$this->error;
    }
    
    private function validateDeletePresenter() {
        if (!$this->user->hasPermission('modify', 'content/event')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        return !$this->error;
    }
    
    private function validateRoster() {
        if (!$this->user->hasPermission('modify', 'content/event')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        return !$this->error;
    }
    
    public function slug() {
        $this->language->load('catalog/product');
        $this->theme->model('tool/utility');
        
        $json = array();
        
        if (!isset($this->request->get['name']) || $this->encode->strlen($this->request->get['name']) < 1):
            $json['error'] = $this->language->get('lang_error_name_first');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['name']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                if (isset($this->request->get['event_id'])):
                    if ($query != 'product_id:' . $this->request->get['event_id']):
                        $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                    else:
                        $json['slug'] = $slug;
                    endif;
                else:
                    $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
