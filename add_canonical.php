<?php
/*
Plugin Name: Add Tag Cannonical
Plugin Uri: https://github.com/ivacms/add_canonical
Author: Иванов Алексей
Description: Данный плагин добавляет в header сайта тег с канонической ссылкой.
Version: 1.0
Author Uri: http://ivacms.ru
*/

class add_cannocial{

	/*******************************************************
	
	Загружаем метод load() вместе с хуком wp_head
	
	********************************************************/

	public function __construct(){
	
		add_action('wp_head',array($this,'load'));
		
	}
	
	/*******************************************************
	
	Функция для проверки текущей страницы посетителя и загрузки соответствующего метода
	
	********************************************************/
	
	public function load(){
	
		//Если постраничная навигация
	
		if($this->is_page()){
		
			// Если рубрика
	
			if(is_category()){
		
				$this->add_canonical_category();
			
			}
			
			// Если категории товаров
			
			elseif( function_exists('is_product_category') ){
			
				if(is_product_category()){
				
					$this->add_canonical_category();
				
				}
			
			}
			
			// Если главная
			
			elseif( is_home() ){
		
				$this->add_canonical_main();

			}
		
	
		}
	
		
	}
	
	/*******************************************************
	
	Проверям находится ли посетитель на одной из страниц (1,2,3,4)
	
	********************************************************/
	
	public function is_page(){
	
		if( get_query_var('paged')>0 )return true; else return false;
	
	}
	
	
	/*******************************************************
	
	Добавляем тег в рубриках и категориях интернет магазина
	
	********************************************************/
	
	public function add_canonical_category(){
			
		//Вытащим из объекта, ID текущей категории
		
		$cat_id=get_queried_object()->term_id;
		
		//Получаем ссылку на данную категорию
		
		$link=get_category_link( $cat_id);
		
		//Добавляем в header новый тег
		
		echo "<link rel=\"canonical\" href=\"".$link."\" />";
	
	}
	/*******************************************************
	
	Добавляем тег на главной странице
	
	********************************************************/
	
	public function add_canonical(){
		
		//Достаём из базы данных ссылу на основной сайт
	
		$link=get_option('siteurl');
		
		//Добавляем в header новый тег
	
		return "<link rel=\"canonical\" href=\"".$link."\" />";
		
	}

}

new add_cannocial;