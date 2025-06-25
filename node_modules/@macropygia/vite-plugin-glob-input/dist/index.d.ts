import type FastGlob from 'fast-glob';
import type { Plugin } from 'vite';
export interface UserSettings {
    patterns: FastGlob.Pattern | FastGlob.Pattern[];
    options?: FastGlob.Options;
    disableAlias?: boolean;
    homeAlias?: string;
    rootPrefix?: string;
    dirDelimiter?: string;
    filePrefix?: string;
}
declare const vitePluginGlobInput: (userSettings: UserSettings) => Plugin;
export default vitePluginGlobInput;
