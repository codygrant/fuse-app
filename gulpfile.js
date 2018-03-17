var gulp        = require('gulp');
var sass        = require('gulp-sass');

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
    return gulp.src('assets/scss/*.scss')
        .pipe(sass())
        .pipe(gulp.dest("public/css"))
});

// Move the javascript files into our /src/js folder
gulp.task('js', function() {
    return gulp.src(['vendor/twbs/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'vendor/components/jquery/jquery.min.js',
        'assets/js/**/*.js'
    ])
        .pipe(gulp.dest("public/js"))
});

// Watch
gulp.task('watch', ['sass'], function() {
    gulp.watch('assets/scss/**/*.scss', ['sass']);
    gulp.watch('assets/js/**/*.js', ['js']);
});