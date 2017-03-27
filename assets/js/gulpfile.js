var gulp = require("gulp");
var sass = require("gulp-sass");
var notify = require("gulp-notify");

gulp.task('compilar-scss', function(){
	return gulp.src('./SCSS/*.scss')
	.pipe(sass({outputStyle:'compressed'}))
	.on('error', notify.onError({title: 'Erro ao compilar', message: '<%= error.message %>'}))
	.pipe(gulp.dest('../css/custom-css/'));
});

gulp.task('listen', function(){
	gulp.watch('./SCSS/*.scss', ['compilar-scss']);
});