//Gulp, para automatizar trabajos repetitivos

import path from 'path'
import fs from 'fs'
import {glob} from 'glob'
import {src, dest, watch, series} from 'gulp' //Src nos permitira acceder a otros archivos. Dest es donde se van almacenar esos archivos. Watch, para estar en escucha de cambios y actualizar automaticamente. Series, nos permitira ejecutar una tarea y despues otra (usandola para ejecutarla funcion dev y js).
import * as dartSass from 'sass' //Importando todo lo que hay en sass y le dimos el nombre de dartSass
import gulpSass from 'gulp-sass' //Para poder usar todas las funciones en este archivo
import terser from 'gulp-terser' //Para mimificar o compactar el codigo JS
import sharp from 'sharp' //Para poner mas pequenas las imagenes

const sass = gulpSass(dartSass); //Voy a compilar Sass utilizando las dependencias de gulpSass.

export function js(done) { //Done, es para que finalice la funcion
    src('src/js/app.js')
        .pipe(terser())
        .pipe(dest('build/js'))

    done()
}

export function css(done) {
    src('src/scss/app.scss', {sourcemaps: true}) //SourceMaps, para saber si tenemos que editar algo, saber en cual .scss debemos ir  a modificarlo
        .pipe(sass({outputStyle: 'compressed' }).on('error', sass.logError)) //Ejecutar funcion que compila el scss a css. Outputstyle, para comprimir el css para mejor performance. On(), es un listener que nos ayuda a encontrar errores.
        .pipe(dest('build/css', {sourcemaps: true})) //Donde guardara la compilacion 
    done()
}

//Para hacer las imagenes mas pequenas en la galeria, con NODE.JS
export async function crop(done) {
    const inputFolder = 'src/img/gallery/full'
    const outputFolder = 'src/img/gallery/thumb';
    const width = 250;
    const height = 180;
    if (!fs.existsSync(outputFolder)) { //Viendo si existe la carpeta thumb sino la creara
        fs.mkdirSync(outputFolder, { recursive: true })
    }
    const images = fs.readdirSync(inputFolder).filter(file => { //Confirmando que son imagenes para procesarlas
        return /\.(jpg)$/i.test(path.extname(file));
    });
    try {
        images.forEach(file => { //Procesando cada una de las imagenes
            const inputFile = path.join(inputFolder, file) //Entrada
            const outputFile = path.join(outputFolder, file) //Salida
            sharp(inputFile) 
                .resize(width, height, {
                    position: 'centre'
                })
                .toFile(outputFile)
        });

        done() //Diciendo que ya finalizo
    } catch (error) {
        console.log(error)
    }
}

//Convirtiendo las imagenes en formato WEBP con NODE.JS
export async function imagenes(done) { //Esta busca las imagenes
    const srcDir = './src/img';
    const buildDir = './build/img';
    const images =  await glob('./src/img/**/*{jpg,png}')

    images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        procesarImagenes(file, outputSubDir);
    });
    done();
}

function procesarImagenes(file, outputSubDir) { //Esta procesa las imagenes
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }
    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`)
    const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`)

    const options = { quality: 80 }
    sharp(file).jpeg(options).toFile(outputFile)
    sharp(file).webp(options).toFile(outputFileWebp)
    sharp(file).avif().toFile(outputFileAvif)
}

//Para guardar cambios automaticamente
export function dev() { 
    watch('src/scss/**/*.scss', css) //Para que siga escuchando por cambios en todas las carpetas que estan en scss y todos los archivos que tengan la extension scss y se actualice(llamando la funcion css).
    watch('src/js/**/*.js', js) //Lo mismo que arriba pero para js.
    watch('src/img/**/*.{png,jpg}', imagenes) //Lo mismo que arriba pero para las imagenes.
}

export default series(crop, js, css, imagenes, dev) //Eliminamos el dev en el package.json porque esto no tiene nombre al que llamar (aun asi cuando lo podremos en la terminal como dev, npm run dev), por lo que se ejecutara primero crop, js, css, imagenes y ultimo el dev porque el dev tiene el watch para actualizar los cambios que se hagan
