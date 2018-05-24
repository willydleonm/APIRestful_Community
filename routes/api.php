<?php

use Illuminate\Http\Request;
//Rutas para los diferentes recursos desde el controlador especificado

/**
* Users => Usuarios
* Se le va a permitir operaciones excepto crear y editar vistas solo desde este controlador
**/
Route::resource('users','User\UserController', ['except' => ['create','edit']]);
//Post Favoritos por Usuario
Route::resource('users.favorites','User\UserFavoriteController', ['only' => ['index']]);

Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');


/**Semester => Semestre
**Semestre solo podrá ver directamente los semestres
**/
Route::resource('semesters','Semester\SemesterController', ['except' => ['create','edit']]);
Route::resource('semesters.courses','Semester\SemesterCourseController', ['only' => ['index']]);

/**
* Courses => Cursos
**/
Route::resource('courses','Course\CourseController', ['except' => ['create','edit']]);

/**
* Posts => Publicaciones
**/
Route::resource('posts','Post\PostController', ['except' => ['create','edit']]);
//Comentarios por post
Route::resource('posts.comments','Post\PostCommentController', ['only' => ['index']]);

/**
* Photos => Fotos
**/
Route::resource('photos','Photo\PhotoController', ['except' => ['create','edit']]);

/**
* Comments => Comentarios
**/
Route::resource('comments','Comment\CommentController', ['except' => ['create','edit']]);

/**
* Favorites => Favoritos
**/
Route::resource('favorites','Favorite\FavoriteController', ['except' => ['create','edit']]);