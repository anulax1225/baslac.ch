export default class Platform {
    static currentPlatform = "";

    static asChanged() {
        let result = Platform.currentPlatform != Platform.detect();
        Platform.currentPlatform = Platform.detect();
        return result;
    }

    static detect() {
        if(window.innerWidth < 640) return "mobile";
        else if (window.innerWidth < 1150) return "tablet";
        else if(window.innerWidth < 1450) return "laptop";
        else return "desktop";
    }

    static getLower(platform) {
        switch(platform) {
            case "mobile": return "mobile";
            case "tablet": return "mobile";
            case "laptop": return "tablet";
            case "desktop": return "laptop"; 
        }
    }

    static superiorTo(platform) {
        let pf = Platform.detect();
        while(Platform.asLower(pf)) {
            pf = Platform.getLower(pf);
            if(platform == pf) return true;
        }
        return false;
    }

    static asLower(platform) {
        return platform != "mobile";
    }
}
