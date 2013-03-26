<?php
/**
 * Message in 4 differet languages to be outputed as the greeting.
 * Message was too large for the database. 
 */
isset($_GET['lang']) ? 	$lang = $_GET['lang'] : $lang = 'russian';

if ($lang == 'english') 		{
	$message = 'A new Brainsorm is submitted approximately  every 2-3 days with 10 setup line each. ';
	$message .= 'Only users with writer status can submit a joke setup. ';
	$message .= 'Joke setups should be creative and interesting with provoking information. ';
	$message .= 'Also they should be a completed sentences of phrases ';
	$message .= 'For example: "I looked at the sky and I saw... " This is unacceptable and linguistically incorrect. ';
	$message .= 'Writes are trapped, because you can see limited number of objects in the sky (bird, plane, clouds) and there is no conflict. ';
	$message .= 'Try to keep up with format action->reaction, when one of the messages is missing and writers have to finish it. ';
	$message .= 'Looking at other writers answers is acceptable. If you can get inspired by somebodies punch line, and you can tweak it, good for you and good for us. ' ;
	$message .= 'Quality of the joke only will increase, and that what we are aiming  for.'	;

} elseif ($lang == 'ukrainian') 	{
	$message = 'Примерно пять раз в неделю добовляется новый брейншторм (по 10 вопросов). ';
	$message .= 'Только авторы могут задавать вопросы. ';
	$message .= 'Вопросы должны быть интересными, содержать информацию провокационного типа и быть завершенными фразами или предложениями. ';
	$message .= 'Например: "Я посмотрел в небо, а там летит..." В данном случае вопрос составлен не коректно. ';
	$message .= 'Отвечающие попадают в жёсткие рамки, так как по небу может лететь ограниченное количество объектов (самолёт, птица, ракета и так далее). ';
	$message .= 'Постарайтесь выдерживать формат причина->следствие, когда одно из утверждений отсутствует, и резиденты должны додумать. ';
	$message .= 'Допускается смотреть на чужие ответы, и если чей-то ответ (удачный или не очень) сможет вас подтолкнуть на более красивый ответ - флаг вам в руки! Мы от этого только выиграем.' ;	
}else 							{
	$message = 'Примерно пять раз в неделю добовляется новый брейншторм (по 10 вопросов). ';
	$message .= 'Только авторы могут задавать вопросы. ';
	$message .= 'Вопросы должны быть интересными, содержать информацию провокационного типа и быть завершенными фразами или предложениями. ';
	$message .= 'Например: "Я посмотрел в небо, а там летит..." В данном случае вопрос составлен не коректно. ';
	$message .= 'Отвечающие попадают в жёсткие рамки, так как по небу может лететь ограниченное количество объектов (самолёт, птица, ракета и так далее). ';
	$message .= 'Постарайтесь выдерживать формат причина->следствие, когда одно из утверждений отсутствует, и резиденты должны додумать. ';
	$message .= 'Допускается смотреть на чужие ответы, и если чей-то ответ (удачный или не очень) сможет вас подтолкнуть на более красивый ответ - флаг вам в руки! Мы от этого только выиграем.' ;	
} 


echo '<br>' . $message;


?>