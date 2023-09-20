import gulp from 'gulp';
import svgSprite from 'gulp-svg-sprite';

const config = {
    mode: {
        symbol: {
            dest: '.',
            sprite: 'sprite.svg'
        }
    }
}

gulp.task('svg', function() {
    return gulp.src('../images/**/*.svg')
        .pipe(svgSprite(config))
        .pipe(gulp.dest('../images'))
})