export default class Utils {
    static Prevent(e) {
        e.preventDefault();
        e.stopPropagation();
    }
}
