<?php

	namespace App\Repositories\Admin;


	use App\Repositories\CoreRepository;
	use App\Models\Admin\Currency as Model;
	use App\Models\Admin\Currency;
	/**
	 * 
	 */
	class CurrencyRepository extends CoreRepository
	{
		
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}

		/** All Currency */
		public function getAllCurrency(){
			$curr = $this->startConditions()::all();
			return $curr;
		}

		/**Switch Base Currency*/
		public function switchBaseCurr(){
			$id = \DB::table('currencies')
				->where('base', '=', '1')
				->get()
				->first();
			if ($id) {
				$id = $id->id;
				$new = Currency::find($id);
				$new->base = '0';
				$new->save();

			} else {
				return back()
					->withErrors(['msg' => "Ошибка Базоваой валюты ещё нет"])
					->withInput();
			}
		}


		/** Get Info By ID */
		public function getInfoCurrency($id){
			$cur = $this->startConditions()
				->find($id); 
			return $cur;
		}

		/***/
		public function deleteCurrency($id){
			$delete = $this->startConditions()->where('id', $id)->forceDelete();
			return $delete;
		}
	}