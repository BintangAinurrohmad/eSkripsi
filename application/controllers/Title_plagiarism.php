<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Title_plagiarism extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Title_model'); // Load the model
	}

	function winnowing($text, $kgram_length = 5, $window_size = 4)
	{
		$text = strtolower($text); // Convert text to lowercase
		$text = preg_replace('/\s+/', '', $text); // Remove all whitespace
		$text = preg_replace('/[^a-z0-9]/', '', $text); // Remove all non-alphanumeric characters

		// Generate k-grams
		$kgrams = [];
		for ($i = 0; $i <= strlen($text) - $kgram_length; $i++) {
			$kgrams[] = substr($text, $i, $kgram_length);
		}

		// Hash k-grams
		$hashes = [];
		foreach ($kgrams as $kgram) {
			$hashes[] = crc32($kgram);
		}

		// Generate fingerprints using sliding window
		$fingerprints = [];
		for ($i = 0; $i <= count($hashes) - $window_size; $i++) {
			$window = array_slice($hashes, $i, $window_size);
			$fingerprints[] = min($window); // Select minimum hash in window
		}

		return array_unique($fingerprints); // Return unique fingerprints
	}

	// function calculate_similarity($fingerprints1, $fingerprints2)
	// {
	// 	if (count($fingerprints1) == 0) {
	// 		return 0; // Return 0 similarity if no fingerprints are generated
	// 	}

	// 	$intersection = array_intersect($fingerprints1, $fingerprints2);
	// 	$similarity = (count($intersection) / count($fingerprints1)) * 100;

	// 	return $similarity;
	// }

	function calculate_similarity($fingerprints1, $fingerprints2)
	{
		$intersection = array_intersect($fingerprints1, $fingerprints2); // Perpotongan fingerprint
		$union = array_unique(array_merge($fingerprints1, $fingerprints2)); // Gabungan fingerprint

		// Menghitung Jaccard Coefficient
		$similarity = (count($intersection) / count($union)) * 100;

		return $similarity;
	}

	function check_plagiarism($new_title, $approved_titles)
	{
		$results = [];
		$new_title_fingerprints = $this->winnowing($new_title);

		foreach ($approved_titles as $approved) {
			$approved_title_fingerprints = $this->winnowing($approved['judul']);
			$similarity = $this->calculate_similarity($new_title_fingerprints, $approved_title_fingerprints);

			if ($similarity > 0) {
				$results[] = [
					'approved_title' => $approved['judul'],
					'nama_mahasiswa' => $approved['nama_mahasiswa'],
					'similarity' => round($similarity, 2)
				];
			}
		}

		// Sort results by similarity in descending order
		usort($results, function ($a, $b) {
			return $b['similarity'] <=> $a['similarity'];
		});

		return $results;
	}

	public function index()
	{
		$new_title = $this->input->post('new_title');

		if (empty($new_title) || str_word_count($new_title) < 2) {
			echo json_encode(['error' => 'Judul terlalu pendek atau kosong.']);
			return;
		}

		$approved_titles = $this->Title_model->getCombinedTitles();


		$result = $this->check_plagiarism($new_title, $approved_titles);

		echo json_encode($result);
	}
}
