<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Kelompok extends BpjsService
{
		public function getKelompokClub ($kdJnsKelompok) {
			return $this->get('kelompok/club/' . $kdJnsKelompok);
		}
		
		public function getKelompokKegiatan ($bulan) {
			return $this->get('kelompok/kegiatan/' . $bulan);
		}
		
		public function getKelompokPeserta ($eduId) {
			return $this->get('kelompok/peserta/' . $eduId);
		}
		
		public function insertKelompokKegiatan ($data = []) {
			return $this->post('kelompok/kegiatan', $data);
		}
		
		public function insertKelompokPeserta ($data = []) {
			return $this->post('kelompok/peserta', $data);
		}
		
		public function deleteKelompokKegiatan ($eduId) {
			return $this->delete('kelompok/kegiatan/' . $eduId);
		}
		
		public function deleteKelompokPeserta ($eduId, $noKartu) {
			return $this->delete('kelompok/peserta/' . $eduId . '/' . $noKartu);
		}
}