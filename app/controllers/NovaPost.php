<?php

namespace App\Controllers;

use App\Models\City;
use App\Utility\Curl;
use App\Utility\Database;
use stdClass;

class NovaPost extends Controller
{
	private string $url = 'https://api.novaposhta.ua/v2.0/json/';

	public function getCities()
	{
		$res = @json_decode($this->makeRequest('Address', 'getCities'), true);
		return ($res['success'] ? $res['data'] ?? [] : []);
	}

	public function updateCities(): void
	{
		set_time_limit(0);

		$dbh = Database::instance()->getDbh();

		try {
			$cities = $this->getCities();
			$stmt = $dbh->prepare("
				TRUNCATE `cities`
			");
			$stmt->execute();

			$stmt = $dbh->prepare("
            INSERT INTO `cities` (
                  `ref`, 
                  `name_ua`, 
                  `name_ru`, 
                  `area_ref`, 
                  `settlement_type`, 
                  `latitude`, 
                  `longitude`, 
                  `region`, 
                  `region_ua`, 
                  `region_ru`, 
                  `index1`, 
                  `index2`, 
                  `index_coatsu`, 
                  `special_cash_check`, 
                  `has_warehouse`
          	) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
			foreach ($cities as $city) {
				$stmt->execute([
					$city['Ref'],
					$city['Description'],
					$city['DescriptionRu'],
					$city['Area'],
					$city['SettlementType'],
					$city['Latitude'] ?? null,
					$city['Longitude'] ?? null,
					$city['Region'] ?? null,
					$city['RegionUa'] ?? null,
					$city['RegionRu'] ?? null,
					$city['Index1'] ?? null,
					$city['Index2'] ?? null,
					$city['IndexCoatsu'] ?? null,
					$city['SpecialCashCheck'] ?? null,
					$city['HasWarehouse'] ?? null
				]);
				usleep(3000);
			}
			echo 'ok';
		} catch (\Exception $e) {
			dd($e);
		}
	}

	private function getWarehouses($page, $limit = 1000)
	{
		$res = @json_decode($this->makeRequest('Address', 'getWarehouses', [
			'Limit' => $limit,
			'Page' => $page
		]), true);
		return ($res['success'] ? $res['data'] ?? [] : []);
	}

	public function updateWarehouses(): void
	{
		set_time_limit(0);

		$dbh = Database::instance()->getDbh();
		$stmt = $dbh->prepare("TRUNCATE `warehouses`");
		$stmt->execute();

		$stmt = $dbh->prepare("
		    INSERT INTO `warehouses` (
				`site_key`, `description`, `description_ru`, `short_address`, `short_address_ru`, 
		        `phone`, `type_of_warehouse`, `ref`, `number`, `city_ref`, `city_description`, 
		        `city_description_ru`, `settlement_ref`, `settlement_description`, `settlement_area_description`, 
		        `settlement_regions_description`, `settlement_type_description`, `settlement_type_description_ru`, 
		        `longitude`, `latitude`
		    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		");

		$page = 1;

		do {
			$warehouses = $this->getWarehouses($page);
			if (!empty($warehouses)) {
				foreach ($warehouses as $wh) {
					$stmt->execute([
						$wh['SiteKey'] ?? null,
						$wh['Description'] ?? null,
						$wh['DescriptionRu'] ?? null,
						$wh['ShortAddress'] ?? null,
						$wh['ShortAddressRu'] ?? null,
						$wh['Phone'] ?? null,
						$wh['TypeOfWarehouse'] ?? null,
						$wh['Ref'] ?? null,
						$wh['Number'] ?? null,
						$wh['CityRef'] ?? null,
						$wh['CityDescription'] ?? null,
						$wh['CityDescriptionRu'] ?? null,
						$wh['SettlementRef'] ?? null,
						$wh['SettlementDescription'] ?? null,
						$wh['SettlementAreaDescription'] ?? null,
						$wh['SettlementRegionsDescription'] ?? null,
						$wh['SettlementTypeDescription'] ?? null,
						$wh['SettlementTypeDescriptionRu'] ?? null,
						$wh['Longitude'] ?? null,
						$wh['Latitude'] ?? null
					]);
					usleep(3000);
				}
				$page++;
			} else {
				break;
			}
		} while (!empty($warehouses));
		echo 'ok';
	}

	private function makeRequest($model, $method, $properties = []): bool|string
	{
		return Curl::POST($this->url, json_encode([
			'apiKey' => NOVA_POST_API_KEY,
			'modelName' => $model,
			'calledMethod' => $method,
			'methodProperties' => (object)$properties
		]), [
			'Content-Type: application/json'
		]);
	}
}