(function () {
    'use strict';

    const   path = require('path'),

            isProduction = process.env.NODE_ENV === 'production',
            projectRoot = path.resolve(__dirname, '../../');

    module.exports = {
        cacheBusting: isProduction ? '[name]_[hash]' : '[name]',
        isProduction: isProduction,
        paths: {
            assets: path.resolve(projectRoot, 'frontend/assets'),
            dist: path.resolve(projectRoot, 'public/dist'),
            root: projectRoot
        }
    };
}())
