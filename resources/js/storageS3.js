export default class StorageS3
{
    static options = 
    {
        genUrl: "/s3/generate-presigned-url",
        startMultipartUrl: "/s3/start-multipart-upload",
        genMultipartUrl: "/s3/generate-presigned-multipart-url",
        completeMultipartUrl: "/s3/complete-multipart-upload",
        proxyMultipartUrl: "/s3/proxy-multipart-upload",
        partSize: 32 * 1024 * 1024,
    }

    static async UploadFile(file, callbacks = {
        onUpdate: async (done) => {},  
        onSuccess: async () => {},
        onError: async () => {}
    }) 
    {
        try {
            const uploadPromises = [];
            let data = new Uint8Array(await file.arrayBuffer());
            const { uploadId, key } = await StorageS3.StartMultiPartUpload(file.name);
            let partIndex = 0;
            for (let start = 0; start < file.size; start += StorageS3.options.partSize)
            {
                partIndex++;
                let partNumber = partIndex;
                let length = start + StorageS3.options.partSize < file.size ? start + StorageS3.options.partSize : file.size;
                if(callbacks.onUpdate) await callbacks.onUpdate((length/file.size) * 100);
                await new Promise(r => setTimeout(r, 200));
                const partData = data.subarray(start, length);
                uploadPromises.push(
                    StorageS3.GenerateMultipartSignedUrl(key, uploadId, partNumber, partData.length)
                    .then(({ url }) => StorageS3.UploadPart(url, partData, partNumber))
                    .then(({ ETag }) => ({ ETag, PartNumber: partNumber }))
                );
            }
            let parts = await Promise.all(uploadPromises);
            parts = parts.sort((a, b) => a.PartNumber - b.PartNumber);
            await StorageS3.CompleteMultiPartUpload(key, uploadId, parts);
            if(callbacks.onSuccess) await callbacks.onSuccess(key);
        } catch(e) { if(callbacks.onError) await callbacks.onError(e); }
    }

    static async StartMultiPartUpload(key)
    {
        const response = await fetch(`${StorageS3.options.startMultipartUrl}?filename=${encodeURIComponent(key)}`, {
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
            },
        });
        return response.json();
    }

    static async GenerateMultipartSignedUrl(key, uploadId, partNumber, partLength)
    {
        const response = await fetch(`${StorageS3.options.genMultipartUrl}?key=${encodeURIComponent(key)}&uploadId=${uploadId}&partNumber=${partNumber}&partLength=${partLength}`, {
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
            },
        });
        return response.json(); 
    }

    static async GenerateSignedUrl(key)
    {
        const response = await fetch(`${StorageS3.options.genUrl}?key=${encodeURIComponent(key)}`, { method: "GET" });
        return response.json(); 
    }

    static async UploadPart(signedUrl, partData, partNumber)
    {
        const response = await fetch(signedUrl, {
            method: 'PUT',
            headers: {
                "Content-Type": "binary/octet-stream",
                "Content-Length": partData.length,
            },
            body: partData,
        });
        if (!response.ok) {
            console.log(response);
            throw new Error(`Failed to upload part: ${partNumber} `);
        }
        return response.json(); // Returns ETag
    }

    static async ProxyUploadPart(signedUrl, partData, partNumber)
    {
        const response = await fetch(`${StorageS3.options.proxyMultipartUrl}`, {
            method: 'PUT',
            headers: {
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
                "X-SignedUrl": signedUrl,
                "Content-Length": partData.length,
            },
            body: partData,
        });
        if (!response.ok) {
            throw new Error(`Failed to upload part: ${partNumber} ${response}`);
        }
        return response.json(); // Returns ETag
    }

    static async CompleteMultiPartUpload(key, uploadId, parts)
    {
        const response = await fetch(StorageS3.options.completeMultipartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value,
            },
            body: JSON.stringify({
                key,
                uploadId,
                parts,
            }),
        });
        return response.json();
    }
}
