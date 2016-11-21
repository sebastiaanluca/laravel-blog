const Helpers = require('./helpers')
const path = require('path')
const _ = require('lodash')

const webpack = require('webpack')
const autoprefixer = require('autoprefixer')
const ManifestPlugin = require('webpack-manifest-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

const isProduction = process.env.APP_ENV === 'production'
const defaultFilename = isProduction ? '[name]-[hash]' : '[name]'
const target = isProduction ? 'resources/assets/dist' : 'public/vendor/blog'

const styleParser = new ExtractTextPlugin(`styles/${defaultFilename}.css`)

const config = {
    
    // Sourcemaps, etc.
    devtool: isProduction ? false : 'cheap-module-eval-source-map',
    
    entry: {
        'blog-admin': ['./resources/assets/src/admin/scripts/admin.js'],
        // Vendors will be added later dyanamically
    },
    
    output: {
        // An absolute path to the desired output directory
        path: path.resolve(process.cwd(), target),
        
        // A filename pattern for the output files. This would create 
        // `global.js` and `portfolio.js`
        filename: `scripts/${defaultFilename}.js`,
        
        // Used to define the root path of the publicly accessible assets
        publicPath: '/vendor/blog/',
    },
    
    module: {
        loaders: [
            {
                // Watch for changes in HTML files
                test: /\.html$/,
                loader: 'raw-loader'
            },
            
            {
                test: /\.jsx?$/i,
                // Don't (re)compile vendor JS files
                exclude: /(node_modules|bower_components)/,
                // 'babel-loader' is also a legal name to reference
                loader: 'babel',
                query: {
                    presets: ['es2015'],
                    plugins: ['transform-strict-mode'],
                }
            },
            
            {
                test: /\.vue$/,
                loader: 'vue',
            },
            
            {
                // Compile CSS and SASS stylesheets with sourcemaps enabled
                test: /\.s?css$/i,
                loader: styleParser.extract(['css?-autoprefixer?sourceMap!postcss!sass?-autoprefixer?sourceMap']),
            },
            
            {
                // Optimize images
                test: /\.(jpe?g|png|gif|svg)$/i,
                loaders: [
                    'file?name=[path][name].[ext]&manipulateImageContext',
                    'image-webpack'
                ]
            },
            
            // Extract fonts from stylesheets, optimize, and copy to public assets directory
            {
                test: /\.woff(\?v=\d+\.\d+\.\d+)?$/,
                loader: 'url?limit=10000&mimetype=application/font-woff&name=./fonts/[name]/' + (isProduction ? '[hash]' : '[name]') + '.[ext]'
            },
            {
                test: /\.woff2(\?v=\d+\.\d+\.\d+)?$/,
                loader: 'url?limit=10000&mimetype=application/font-woff&name=fonts/[name]/' + (isProduction ? '[hash]' : '[name]') + '.[ext]'
            },
            {
                test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,
                loader: 'url?limit=10000&mimetype=application/octet-stream&name=fonts/[name]/' + (isProduction ? '[hash]' : '[name]') + '.[ext]'
            },
            {
                test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,
                loader: 'file?&name=fonts/[name]/' + (isProduction ? '[hash]' : '[name]') + '.[ext]'
            },
            {
                test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
                loader: 'url?limit=10000&mimetype=image/svg+xml&name=fonts/[name]/' + (isProduction ? '[hash]' : '[name]') + '.[ext]'
            },
        ],
    },
    
    plugins: [
        // Set our environment variables
        new webpack.DefinePlugin({
            'process.env': {
                'APP_ENV': JSON.stringify(process.env.APP_ENV),
                'NODE_ENV': JSON.stringify(process.env.APP_ENV),
            }
        }),
        
        // Log start of compiling
        function () {
            this.plugin('watch-run', function (watching, callback) {
                console.log('Beginning compile at ' + new Date())
                callback()
            })
        },
        
        new ManifestPlugin({
            fileName: 'rev-manifest.json'
        }),
        
        // Provide global support for vendor libraries
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            
            _: 'lodash',
            
            tether: 'tether',
            Tether: 'tether',
            'window.Tether': 'tether',
            
            CodeMirror: 'codemirror',
        }),
        
        // This plugin looks for similar chunks and files and only
        // includes them once (and provides copies when used)
        new webpack.optimize.DedupePlugin(),
        
        // Split vendor resources from application code.
        // Only takes in account elements (JS, CSS, images) included in JS files,
        // not SASS files for instance (separate loader, no support yet).
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vendor',
            minChunks: (module) => Helpers.isExternalModule(module)
        }),
        
        // Extract styles from scripts
        styleParser,
    ],
    
    resolve: {
        // Resolve modules from these directories. Allows to use 
        // vendor/module instead of referencing relatively (../../../)
        modulesDirectories: ['node_modules', 'modules'],
        
        // Only look for these types of files though
        extensions: ['', '.js', '.css', '.scss'],
        
        alias: {
            // Force all modules to use the same jquery version
            // See https://github.com/Eonasdan/bootstrap-datetimepicker/issues/1319#issuecomment-208339466
            'jquery': path.resolve(process.cwd(), 'node_modules/jquery/src/jquery'),
            
            // Use runtime Vue version
            'vue$': path.resolve(process.cwd(), 'node_modules/vue/dist/vue.js'),
        }
    },
    
    // Parses file loaders (only file-loader?) name string and enables you
    // to replace elements within it. Used here to provide a context to 
    // image-webpack-loader and prevent images being placed in 
    // e.g. public/assets/modules/theme/resources/images
    customInterpolateName: function (url, name, options) {
        if (this.query.indexOf('manipulateImageContext') !== -1) {
            url = url.substring(url.indexOf('images'))
        }
        
        return url
    },
    
    // Image optimization settings
    imageWebpackLoader: {
        mozjpeg: {
            quality: 82
        },
        pngquant: {
            quality: "65-90",
            speed: 4
        },
        svgo: {
            plugins: [
                {removeEmptyAttrs: true},
                {cleanupAttrs: true},
                {removeComments: true},
                {removeMetadata: true},
                {removeTitle: true},
                {removeDesc: true},
                {removeEditorsNSData: true},
                {convertStyleToAttrs: true},
                {removeUselessDefs: true},
                {removeUnknownsAndDefaults: true},
                {removeUselessStrokeAndFill: true},
                {convertPathData: true},
                {removeDimensions: true},
            ]
        }
    },
    
    sassLoader: {
        // An array of paths that LibSass can look in to attempt to resolve your @import declarations
        includePaths: [
            path.resolve(process.cwd(), 'modules'),
            path.resolve(process.cwd(), 'node_modules'),
        ],
    },
    
    postcss() {
        return [autoprefixer]
    },
    
    node: {
        // Fixes SimpleMDE package (see https://github.com/NextStepWebs/simplemde-markdown-editor/issues/150)
        fs: 'empty'
    },
    
    devServer: {
        port: process.env.SERVE_PORT || 8080,
        contentBase: target,
        // Where to serve the bundled assets from
        publicPath: process.env.SERVE_PROXY_TARGET + '/vendor/blog',
        // Enable web page updates without reloading
        hot: true,
        https: true,
        
        proxy: {
            '*': {
                target: process.env.SERVE_PROXY_TARGET,
                changeOrigin: true,
                autoRewrite: true,
                xfwd: true,
                secure: false,
            },
        },
        
        watchOptions: {
            aggregateTimeout: 20,
            poll: 1000
        },
    }
}

/* Production */

// Optimize order and uglify JS in production
if (process.env.APP_ENV === 'production') {
    // Add additional plugins
    config.plugins = config.plugins.concat([
        // This plugins optimizes chunks and modules by
        // how much they are used in your app
        new webpack.optimize.OccurenceOrderPlugin(),
        
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                // Suppress uglification warnings
                warnings: false,
            },
            mangle: true,
            screw_ie8: true,
        }),
    ])
}

// Enable the configuration for external use
module.exports = config