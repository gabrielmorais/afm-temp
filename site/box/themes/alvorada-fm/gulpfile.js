var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    sassGlob    = require('gulp-sass-glob'),
    sourcemaps  = require('gulp-sourcemaps'),
    bower       = require('gulp-bower'),
    imagemin    = require('gulp-imagemin'),
    changed     = require('gulp-changed'),
    pngquant    = require('imagemin-pngquant'),
    uglify      = require('gulp-uglify')
    do_concat   = require('gulp-concat'),
    gutil       = require('gulp-util'),
    browserSync = require('browser-sync').create();


var config = {
  bowerDir : './bower_components/',
  site_url : "http://alvorada-fm.dev/"
}

function get_javascripts () {
    javascipts = [
        config.bowerDir + '/jquery/dist/jquery.min.js', 
        config.bowerDir + '/bootstrap-sass/assets/javascripts/bootstrap.min.js', 
        'js/vendor/*.js', 
        'js/*.js'
    ];
    return javascipts;
}

function get_stylesheets() {
    stylesheets = [
        config.bowerDir + '/bootstrap-sass/assets/stylesheets', 
        config.bowerDir + '/font-awesome/scss/',
        config.bowerDir + '/hover/scss/'
    ];
    return stylesheets;
}

/** Instala components com bower **/
gulp.task('bower', function() { 
    return bower()
        .pipe(gulp.dest(config.bowerDir)) 
});

/** Copia os arquivos de font do font-awesome **/
gulp.task('icons', function() { 
    return gulp.src(config.bowerDir + '/font-awesome/fonts/**.*') 
        .pipe(gulp.dest('assets/fonts')); 
});

/** Compila SASS -> CSS e minifica  **/
gulp.task('sass', function () {
  gulp.src(['sass/**/*.scss'])
    .pipe(sassGlob())
    .pipe(sourcemaps.init())
    .pipe(sass({
        outputStyle: 'compressed',
        includePaths: get_stylesheets(),
    }).on('error', sass.logError))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('assets/css'));
});

/** Minifica imagens e joga dentro da pasta prod/imgages  **/
gulp.task('images', function() {
    gulp.src('images/**/*')
        .pipe(changed('assets/images'))
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('assets/images'))
});

/** Compress JS **/
gulp.task('compress', function() {
  gulp.src( get_javascripts() )
      .pipe(do_concat('app.min.js'))
      .pipe(uglify().on('error', gutil.log))
      .pipe(gulp.dest('assets/js'));
});

/** Inicia BrowserSync no watch e escuta arquivos js e css  **/
gulp.task('browser-sync', function() {
    browserSync.init(["assets/css/*.css", "assets/js/*.js"], {
        proxy: config.site_url
    });
});

gulp.task('default', ['bower', 'icons', 'browser-sync'], function () {
    gulp.watch('sass/**/*.scss', ['sass']);
    gulp.watch('images/**/*', ['images']);
    gulp.watch('js/**/*.js', ['compress']);
});