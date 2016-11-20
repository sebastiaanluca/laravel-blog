const path = require('path')
const webpack = require('webpack')
const ManifestPlugin = require('webpack-manifest-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const _ = require('lodash')

const isProduction = process.env.APP_ENV === 'production'
const defaultFilename = isProduction ? '[name]-[hash]' : '[name]'

const styleParser = new ExtractTextPlugin(`styles/${defaultFilename}.css`)

// Get a list of third-party vendors directly from our dependencies list
const packageConfig = require(path.resolve(process.cwd(), './package.json'))
let packages = _.keys(packageConfig.dependencies)
// Remove some vendors that don't have any JS files 
packages = _.pullAll(packages, ['font-awesome'])

const config = {
    devtool: isProduction ? false : 'cheap-module-eval-source-map',
    entry: {
        'vendor': packages,
        'blog-admin': ['./resources/assets/src/admin/scripts/admin.js'],
    },
    output: {
        path: path.resolve(process.cwd(), isProduction ? 'resources/assets/dist' : 'public/vendor/blog'),
        filename: `scripts/${defaultFilename}.js`,
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
                loader: styleParser.extract(['css?!postcss!sass?sourceMap']),
            },
            
            {
                // Optimize images
                test: /\.(jpe?g|png|gif|svg)$/i,
                loaders: [
                    `file?name=[path]${defaultFilename}.[ext]&context=./resources/`,
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
    plugins: [
        // Log start of compiling
        function () {
            this.plugin('watch-run', function (watching, callback) {
                console.log('Begin compile at ' + new Date())
                callback()
            })
        },
        
        // Set our environment variables
        new webpack.DefinePlugin({
            'process.env': {
                'APP_ENV': JSON.stringify(process.env.APP_ENV),
                'NODE_ENV': JSON.stringify(process.env.APP_ENV),
            }
        }),
        
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
        
        // Find duplicate dependencies & prevents duplicate inclusion
        new webpack.optimize.DedupePlugin(),
        
        new webpack.optimize.CommonsChunkPlugin('vendor', isProduction ? 'scripts/vendor-[hash].js' : 'scripts/vendor.js'),
        
        // Compile CSS
        styleParser,
    ],
    resolve: {
        alias: {
            'jquery': path.resolve(process.cwd(), 'node_modules/jquery/src/jquery'),
            'vue$': path.resolve(process.cwd(), 'node_modules/vue/dist/vue.js'),
        }
    },
    node: {
        // Fixes SimpleMDE package (see https://github.com/NextStepWebs/simplemde-markdown-editor/issues/150)
        fs: 'empty'
    },
    devServer: {
        port: process.env.SERVE_PORT || 8080,
        contentBase: 'public/vendor/blog',
        publicPath: process.env.SERVE_PROXY_TARGET + '/vendor/blog',
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
        
        // This plugin prevents Webpack from creating chunks
        // that would be too small to be worth loading separately
        new webpack.optimize.MinChunkSizePlugin({
            // ~50kb
            minChunkSize: 51200,
        }),
        
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