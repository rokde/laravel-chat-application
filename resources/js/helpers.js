import dayjs from 'dayjs';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';
import 'dayjs/locale/de';

dayjs.extend(relativeTime);
dayjs.extend(localizedFormat);
dayjs.locale('de');

/**
 * returns relative time from now
 * @param {string} timestampString
 * @returns {string}
 */
export const humanReadableTimeDiff = (timestampString) => {
    return dayjs(timestampString).fromNow();
}
