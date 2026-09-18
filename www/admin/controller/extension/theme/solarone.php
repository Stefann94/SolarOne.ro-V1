<?php
/**
 * Tema SolarOne - controller de administrare.
 * Permite selectarea temei din Extensii -> Teme si setarea dimensiunilor de imagine.
 */
class ControllerExtensionThemeSolarone extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/theme/solarone');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('theme_solarone', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_directory'] = $this->language->get('entry_directory');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_back'] = $this->language->get('button_back');

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/theme/solarone', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/theme/solarone', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true);

		// Toate setarile temei, cu valori implicite sensibile
		$defaults = array(
			'theme_solarone_status' => 1,
			'theme_solarone_directory' => 'solarone',
			'theme_solarone_product_limit' => 24,
			'theme_solarone_product_description_length' => 120,
			'theme_solarone_image_thumb_width' => 500,
			'theme_solarone_image_thumb_height' => 500,
			'theme_solarone_image_popup_width' => 1000,
			'theme_solarone_image_popup_height' => 1000,
			'theme_solarone_image_category_width' => 400,
			'theme_solarone_image_category_height' => 400,
			'theme_solarone_image_product_width' => 300,
			'theme_solarone_image_product_height' => 300,
			'theme_solarone_image_additional_width' => 100,
			'theme_solarone_image_additional_height' => 100,
			'theme_solarone_image_related_width' => 300,
			'theme_solarone_image_related_height' => 300,
			'theme_solarone_image_compare_width' => 90,
			'theme_solarone_image_compare_height' => 90,
			'theme_solarone_image_wishlist_width' => 60,
			'theme_solarone_image_wishlist_height' => 60,
			'theme_solarone_image_location_width' => 268,
			'theme_solarone_image_location_height' => 50
		);

		foreach ($defaults as $key => $value) {
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} else {
				$setting = $this->config->get($key);
				$data[$key] = ($setting !== null && $setting !== '') ? $setting : $value;
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/theme/solarone', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/theme/solarone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}
