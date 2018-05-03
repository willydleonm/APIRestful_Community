<?php

use Illuminate\Http\Request;
//Rutas para los diferentes recursos desde el controlador especificado

/**
* Users => Usuarios
* Se le va a permitir operaciones excepto crear y editar vistas solo desde este controlador
**/
Route::resource('users','User\UserController', ['except' => ['create','edit']]);


/**Semester => Semestre
**Semestre solo podrá ver directamente los semestres
**/
Route::resource('semesters','Semester\SemesterController', ['only' => ['index','show']]);

/**
* Courses => Cursos
**/
Route::resource('courses','Course\CourseController', ['only' => ['index','show']]);

/**
* Profiles => Perfiles
**/
Route::resource('profiles','Profile\ProfileController', ['only' => ['index','show']]);

/**
* Posts => Publicaciones
**/
Route::resource('posts','Post\PostController', ['only' => ['index','show']]);

/**
* Photos => Fotos
**/
Route::resource('photo','Photo\PhotoController', ['only' => ['index','show']]);

/**
* Comments => Comentarios
**/
Route::resource('comments','Comment\CommentController', ['only' => ['index','show']]);

/**
* Favorites => Favoritos
**/
Route::resource('favorites','Favorite\FavoriteController', ['only' => ['index','show']]);