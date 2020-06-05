<h3>Related posts</h3>
<?php //Цикл №1
//global $post;
$categories = get_the_category($post->ID);
if ($categories) {
 $category_ids = array();
 foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
 }

$args=array(
					'post_type' => array ('post','page'),
					'category__in' => $category_ids,
					'post__not_in' => array( get_the_ID() ), // исключить текущий пост
					'posts_per_page'=> -1,  //количество выводимых ячеек
					//'orderby'=>'rand', // в случайном порядке
					//'meta_key' => 'ratings_users',
					//'orderby' => 'meta_value_num',
					//'order' => 'DESC',
					//'ignore_sticky_posts'=>1, //исключаем одинаковые записи
					'meta_query' => array(
		'rating_ratio'   => array(
            'key' => 'ratings_users',            
        )
	),

	'date_query' => array(		
		array(
			'column' => 'post_modified', // фильтруем не по дате публикации, а по дате обновления поста
			'after'  => '30 day ago',
		)
	),	
	'orderby' => array(  'rating_ratio' => 'DESC' ),
				);
							
$my_array= array(); //обнулить массив							
							
$query = new WP_Query( $args);
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
?>

<?php
 $my_array[] = $post->ID; //пишем в массив ID постов
?>	


<?php endwhile; endif; wp_reset_postdata(); ?>

<?php
//print_r($my_array);
?>	

<?php //Проверка пустой массив или нет
if ($my_array != 'null');
?>

<?php
//Цикл №1
$count_post = 6; //Задаём желаемое значение в Цикле №1
// Проверяем, что если количество желаемых постов в Цикле№1 больше их реального количества - присваем значение реального количества
//и присваем колиечество постов выводимых в Цикле №2
if( $count_post >= count($my_array)) { $count_1_cycle = count($my_array); } else { $count_1_cycle = $count_post; }
?>
<div id="interesting_articles">
<ul>
<?php for ($i = 0; $i < $count_1_cycle; $i++) {
$ID = $my_array[$i];
 ?>
 <li>
 <div class="cell"><a href="<?php the_permalink($ID); ?>">
 <?php echo get_the_post_thumbnail($ID,'thumbnail'); ?></a>
 <br>
<a href="<?php the_permalink($ID) ?>" rel="bookmark" title="<?php echo esc_html( get_the_title($ID) ); ?>">
<?php echo str_replace("for World of Tanks", "", esc_html( get_the_title($ID) )); ?>
</a>
</div>
</li>
<?php }
?>	
</ul>
</div>
<div>
<ul>
<?php // Цикл №2
	for ($i = $count_1_cycle; $i < count($my_array); $i++) {
$ID = $my_array[$i];
 ?>
    <li><a href="<?php the_permalink($ID); ?>" title="<?php the_title_attribute($ID); ?>"><?php echo str_replace("for World of Tanks", "", esc_html( get_the_title($ID) )); ?></a>
</li>
<?php }
	// Конец Цикла №2
?>	
</ul>
</div>							
<?php // Конец проверки пустой массив или нет
?>
	
<?php
//End linking
 ?>
		<style type="text/css">
#interesting_articles{
 margin: 10px 0;   /*  Отступы от верхнего и нижнего края */
 float: left;     /* Прижимаем блок к левому краю */
 width: 100%;  /* Длина блока соответствует ширине страницы */
}
#interesting_articles ul {
 margin-left: 5px;  /*  Внешний отступ от левого края страницы */
 width: 96%;  /* Общая ширина блока без учета отступов от краев страницы */
padding: 0;
}
#interesting_articles li {
 list-style: none;  /* Отменяем нумерацию списка (1,2,3 и т.д.) */
}
.cell{
 height: 160px;  /* Высота ячейки  */
 box-shadow: #F5F5F5 0px 2px 3px, #F5F5F5 0 0 3px inset;  /* Тень для ячеек (необязательно) */
 float: left;   /* Каждая следующая ячейка располагается слева */
 list-style: none;  /* Отменяем родительские стили */
 margin: 5px;  /* Расстояние между ячейками */
 padding: 2px;  /* Отступы от миниатюры до края ячейки */
 text-align: center; /* Текстовые заголовки расположены по центру */
font-weight: 400;
font-size: 14px;
line-height: 1.3;
 width: 170px;  /* ширина одной ячейки */
 overflow: hidden;  /* Окончания длинных заголовков, не вместившихся в ячейку, будут скрыты */
 border: #F5F5F5 solid 1px; /* Рамка вокруг ячейки */
 border-top-left-radius: 10px;  /* Закругление левого верхнего угла ячейки */
 border-top-right-radius: 10px;  /* Закругление правого верхнего угла ячейки */
 border-bottom-left-radius: 10px;  /* Закругление нижнего левого угла ячейки */
 border-bottom-right-radius: 10px;  /*Закругление нижнего правого угла ячейки */
}
.cell a:hover {
 color: #C6C600;  /* Цвет ссылки при наведении курсора */
 text-decoration:none; /* Убираем подчеркивание ссылки */
}
.cell a{
 color: #000000; /* Цвет ссылки */
 text-decoration:none; /* Убираем подчеркивание ссылки */
}
#interesting_articles li :hover{
 background-color: #f9f9f9; /* Цвет фона ячейки при наведении курсора */
}
/* Стили для мобильных устройств */
@media screen and (max-width:760px){
#interesting_articles{
width:auto;
display:block;
position:relative;
}
#interesting_articles ul {
width:auto;
}
#interesting_articles li {
float:left;
}
}
</style>
