/**Подтверждение удаления Заказа*/
$('.delete').click(function(){
	var res = confirm('Подтвердите действия!');
	if (!res) return false;
});

/**Редактирование Заказа**/
$('.redact').click(function () {
	var res = confirm('Вы можете только изменить Комментарий!');
	return false;
});

/**Подтверждение удаление Заказа из БД*/
$('.deletebd').click(function (){
	var res = confirm('Подтвердите действия');
	if(res){
		var ress = confirm('ВЫ УДАЛИТЕ ЗАКАЗ ИЗ БД!')
		if (!ress) return false;
	}
	if (!res) return false;
});

/**Подсвечивание активного меню*/
$('.sidebar-menu a').each(function () {
	var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
	var link = this.href;
	if (link === location) {
		$(this).parent().addClass('active');
		$(this).closest('.treeview').addClass('active')
	}
});

/**KCEditor*/
$('#editorl').ckeditor();
$('#editort').ckeditor();

/*Сброс фильтров админка*/
$('#reset-filter').click(function () {
	$('#filter input[type=radio]').prop('checked', false)
	return false;
});

/*Выбор Категории*/
$('#add').on('submit', function(){
	if (!isNumber($('#parent_id').val())) {
		alert('Выберите категорию');
		return false;
	}
});

/**Является ли поле числом*/
function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
