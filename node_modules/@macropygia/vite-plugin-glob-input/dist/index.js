import path from 'path';
import fg from 'fast-glob';
const defaultSettings = {
    patterns: '**/*.html',
    disableAlias: false,
    homeAlias: 'home',
    rootPrefix: 'root',
    dirDelimiter: '-',
    filePrefix: '_',
};
const convertFilesToInput = (settings, config, input, targetFiles) => {
    targetFiles.forEach((targetFile) => {
        const parsedRelPath = path.parse(path.relative(config.root, targetFile));
        if (parsedRelPath.dir === '') {
            if (parsedRelPath.name === 'index') {
                input[settings.homeAlias] = targetFile;
            }
            else {
                input[settings.rootPrefix + settings.filePrefix + parsedRelPath.name] =
                    targetFile;
            }
        }
        else {
            const prefix = parsedRelPath.dir.replace(path.sep, settings.dirDelimiter);
            if (parsedRelPath.name === 'index') {
                input[prefix] = targetFile;
            }
            else {
                input[prefix + settings.filePrefix + parsedRelPath.name] = targetFile;
            }
        }
    });
    return input;
};
const vitePluginGlobInput = (userSettings) => {
    const settings = {
        ...defaultSettings,
        ...userSettings,
    };
    let config;
    const requiredFgOptions = {
        absolute: true,
    };
    return {
        name: 'vite-plugin-glob-input',
        enforce: 'pre',
        apply: 'build',
        configResolved(resolvedConfig) {
            config = resolvedConfig;
        },
        options: (options) => {
            const fgOptions = {
                ...settings.options,
                ...requiredFgOptions,
            };
            const targetFiles = fg.sync(settings.patterns, fgOptions);
            let { input } = options;
            if (!input || typeof input === 'string')
                input = settings.disableAlias ? [] : {};
            if (Array.isArray(input))
                options.input = [...input, ...targetFiles];
            else
                options.input = convertFilesToInput(settings, config, input, targetFiles);
            return options;
        },
    };
};
export default vitePluginGlobInput;
