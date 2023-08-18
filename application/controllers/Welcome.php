<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function webcam_capture() {
        $this->load->view('webcam_capture');
    }
    
    public function save_image() {
    	 $imageData = $this->input->post('imageData');
        if (!empty($imageData)) {
            $imageName = 'image_' . time() . '.png';
            $imagePath = 'path/to/save/images/' . $imageName;

            // Decode base64 image data
            $imageData = base64_decode(str_replace('data:image/png;base64,', '', $imageData));

            // Save the image
            file_put_contents($imagePath, $imageData);

            // You can save the image path in a database or perform other operations as needed

            echo json_encode(['status' => 'success', 'message' => 'Image saved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No image data received']);
        }

    }
}
