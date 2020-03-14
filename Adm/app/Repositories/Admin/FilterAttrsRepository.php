<?php

	namespace App\Repositories\Admin;

	use App\Models\Admin\AttributeValue as Model;
	use App\Repositories\CoreRepository;


	/**
	 * 
	 */
	class FilterAttrsRepository extends CoreRepository
	{
		
		public function __construct()
		{
			parent::__construct();
		}

		protected function getModelClass()
		{
			return Model::class;
		}

		/**Get Count Attributes Filter by Id*/
		public function getCountFilterAttrsById($id){
			$count = \DB::table('attribute_values')->where('attr_group_id', $id)->count();
			return $count;
		}
		
		/**Get All Attribute filter with name Group*/
		public function getAllAttrsFilter(){
			$attrs = \DB::table('attribute_values')
				->join('attribute_groups', 'attribute_groups.id', '=', 'attribute_values.attr_group_id')
				->select('attribute_values.*', 'attribute_groups.title')
				->paginate();
			return $attrs;
		}

		/**Check unique Name for add new Attribute*/
		public function checkUnique($name)
		{
			$unique = $this->startConditions()->where('value', $name)->count();
			return $unique;
		}

		/**Get Info by Id*/
		public function getInfoProduct($id)
		{
			$product = $this->startConditions()
				->find($id);
			return $product;
		}

		/**Delete one Attribute Filter by Id**/
		public function deleteAttrFilter($id)
		{
			$delete = $this->startConditions()->where('id', $id)->forceDelete();
			return $delete;
		}
	}