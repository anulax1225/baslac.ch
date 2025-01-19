export default class File {
    static SizeToString(size) 
    {
        let cpt = 0;
        let units = ["octet", "Ko", "Mo", "Go", "To"];
        while(size >= 1000 && size >= 1)
        {
            size = size / 1000;
            cpt++;
        }
        return (Math.ceil(size * 100) / 100) + " " + units[cpt];
    }

    static Icon(ext)
    {
        let img = "/icons/fichier.png";
        switch(ext.toLowerCase()) {
            case 'pdf': return "/icons/pdf.png";
            case 'dwg': return "/icons/dwg.png";
            case 'stp':
            case 'step': return "/icons/step.png";
            case 'xlsx': return "/icons/excel.png";
            case 'docx': return "/icons/word.png";
            case 'zip':
            case '7z':
            case 'rar':
            case 'gz': return "/icons/zip.png";
            case "unitypackage": return "/icons/unity.svg";
            case "png":
            case "jfif":
            case "jpeg":
            case "jpg":
            case "gif":
            case "svg":
            case "webp": return "/icons/photo.svg";
        }
        return img;
    }

    static Basename(filename)
    {
        return filename.substring(filename.lastIndexOf('/') > 0 ? filename.lastIndexOf('/') + 1 : 0, filename.lastIndexOf('.')) || filename;
    }

    static Extension(filename)
    {
        return filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
    }

}
