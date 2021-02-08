<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BiddingController extends Controller
{

	public function index(Request $request) {
		$items = array(
		  array(
			'name'            => 'item-a',            # Nama Item
			'price'           => 70000,               # Harga Maximum
			'quantity'        => 1000,                # Jumlah item yang akan dikerjakan
			'production_time' => 8,                   # Lama pengerjaan dalam hari
			'start'           => '2017-11-14 10:00',  # Mulai bidding
			'end'             => '2017-11-14 12:00'   # Akhir bidding
		  ),

		  array(
			'name'            => 'item-b',
			'price'           => 50000,
			'quantity'        => 2000,
			'production_time' => 10,
			'start'           => '2017-11-14 12:00',
			'end'             => '2017-11-14 15:00'
		  )
		);

		$submissions = array(
			array(
				'name' => 'Wili',                   # Nama Partner
				'bidding' => array(
				  	'item-a' => array(                # Submissions untuk item-a
						'2017-11-14 10:00' => array(    # Tanggal submit
					  		'price'           => 65000,   # Harga yang ditawarkan
					  		'production_time' => 9        # Lama pengerjaan dalam hari
						),
						'2017-11-14 12:00' => array(
						  	'price'           => 68000,
						  	'production_time' => 9
						),
						'2017-11-14 10:30' => array(
						  	'price'           => 71000,
						  	'production_time' => 9
						),
						'2017-11-14 12:30' => array(
						  	'price'           => 10000,
						  	'production_time' => 9
						)
				  	),
				  	'item-b' => array(
						'2017-11-14 14:30' => array(
						  	'price'           => 40000,
						  	'production_time' => 9
						),
						'2017-11-14 12:30' => array(
						  	'price'           => 50000,
						  	'production_time' => 9
						)
				  	)
				)
			),

			array(
				'name' => 'Lita',
				'bidding' => array(
				  	'item-b' => array(
						'2017-11-14 13:30' => array(
						  	'price'           => 45000,
						  	'production_time' => 9
						),
						'2017-11-14 15:01' => array(
						  	'price'           => 35000,
						  	'production_time' => 9
						),
						'2017-11-14 12:30' => array(
						  	'price'           => 48000,
						  	'production_time' => 9
						)
				  	)
				)
			  ),

			array(	
				'name' => 'Sabar',
				'bidding' => array(
				  	'item-a' => array(
						'2017-11-14 11:50' => array(
						  	'price'           => 65000,
						  	'production_time' => 9
						),
						'2017-11-14 11:30' => array(
					  		'price'           => 68000,
					  		'production_time' => 9
						),
						'2017-11-14 11:00' => array(
					  		'price'           => 69000,
					  		'production_time' => 9
						)
				  	)
				)
			),

			array(
				'name' => 'Makmur',
				'bidding' => array(
				  	'item-a' => array(
						'2017-11-14 12:00' => array(
						  	'price'           => 50000,
						  	'production_time' => 9
						),
						'2017-11-14 11:00' => array(
					  		'price'           => 5000,
					  		'production_time' => 9
						)
				  	)
				)
			  )
		);

		foreach ($items as $idx => $value) {
			foreach ($submissions as $key => $val) {
				if (isset($val['bidding'][$value['name']])) {
					$output_bid = [];
					foreach ($val['bidding'][$value['name']] as $date => $bid) {
						if (date('Y-m-d H:i', strtotime($date)) >= date('Y-m-d H:i', strtotime($value['start'])) && date('Y-m-d H:i', strtotime($date)) <= date('Y-m-d H:i', strtotime($value['end']))
						) {
							$output_bid[$date] = $bid;
						}
					}
					$val['date'] = max(array_keys($output_bid));
					$val['price'] = $output_bid[max(array_keys($output_bid))]['price'];
					$val['total'] = $output_bid[max(array_keys($output_bid))]['price'] * $value['quantity'];
					unset($val['bidding']);
					$value['bidding'][$value['name']][] = $val;
				}
			}
			usort($value['bidding'][$value['name']], function($a, $b) {
				return $a['total'] < $b['total'] ? -1 : 1;
			});
			$items[$idx] = $value;
		}
		foreach ($items as $key => $value) {
			echo "\n# " . $value['name'] ." - " . $value['quantity'] . " - " . $value['price'] . "\n";
			echo "Peserta (" . count($value['bidding'][$value['name']]) . "): \n";
			foreach ($value['bidding'][$value['name']] as $idx => $val) {
				echo ($idx + 1) . ". " . $val['name'] . " - " . $val['date'] . " " . $val['price'] . " " . $val['total'] . "\n";
			}
		}
		die();

		$array_item_a =  collect($submissions)->transform(function($item,$key) {
			$bidding =collect($item)->pluck('item-a')->filter()->first();
			$item_bidding = collect($bidding)->sortKeysDesc()->all();
			$item['item_bidding'] = $item_bidding;
			return collect($item)->except('bidding');
		});
		$data_a = collect($array_item_a)->where('item_bidding', '!=', null)->values();
		$total_peserta_a = count($data_a);
		$bidding_item_a = collect($data_a)->transform(function($item, $key)  use ($data_a) {
			$date = collect($item['item_bidding'])->transform(function($item, $key) {
				$item['date'] = $key;
				return $item;
			});
			$data = collect($date)->first();
			$item['price'] = $data['price'];
			$item['date'] = $data['date'];
			return collect($item)->except('item_bidding');
		});


		$array_item_b =  collect($submissions)->transform(function($item) {
			$bidding =collect($item)->pluck('item-b')->filter()->first();
			$item_bidding = collect($bidding)->sortKeysDesc()->all();
			$item['item_bidding'] = $item_bidding;
			return collect($item)->except('bidding');
		});

		$data_b = collect($array_item_b)->where('item_bidding', '!=', null)->values();
		$total_peserta_b = count($data_b);
		$bidding_item_b = collect($data_b)->transform(function($item, $key) {
			$date = collect($item['item_bidding'])->transform(function($item, $key) {
				$item['date'] = $key;
				return $item;
			});
			$data = collect($date)->first();
			$item['date'] = $data['date'];
			$item['price'] = $data['price'];
			return collect($item)->except('item_bidding');
		});

		return [
			'item-a' => [
							'total_peserta' => $total_peserta_a, 
							'peserta' => $bidding_item_a
						], 
			'item-b' => [
							'total_peserta' => $total_peserta_b, 
							'peserta' => $bidding_item_b
						]
			];
			
		

	}
}
