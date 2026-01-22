export function returnMaskChassi(chassi){
    return '*'.repeat(7) + chassi.slice(7);
}

export async function compressImage(
    file,
    convertToBlackAndWhite = false,
    adjustBrightnessExposure = false
) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = async (event) => {
            const img = new Image();
            img.src = event.target.result;
            img.onload = () => {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");
                const maxWidth = 1080;
                const maxHeight = 1080;
                let width = img.width;
                let height = img.height;

                if (width > maxWidth) {
                    height *= maxWidth / width;
                    width = maxWidth;
                }
                if (height > maxHeight) {
                    width *= maxHeight / height;
                    height = maxHeight;
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                if (convertToBlackAndWhite) {
                    const imageData = ctx.getImageData(
                        0,
                        0,
                        width,
                        height
                    );
                    const data = imageData.data;
                    for (let i = 0; i < data.length; i += 4) {
                        const avg =
                            (data[i] + data[i + 1] + data[i + 2]) / 3;
                        data[i] = avg; // Vermelho
                        data[i + 1] = avg; // Verde
                        data[i + 2] = avg; // Azul
                    }
                    ctx.putImageData(imageData, 0, 0);
                }

                if (adjustBrightnessExposure) {
                    const imageData = ctx.getImageData(
                        0,
                        0,
                        width,
                        height
                    );
                    const data = imageData.data;
                    const brightnessMultiplier = 5; // brilho
                    const exposureMultiplier = 2; // exposição
                    const blackToneThreshold = 80; //  preto
                    const whiteToneThreshold = 600; //  branco

                    for (let i = 0; i < data.length; i += 4) {
                        if (
                            data[i] <= blackToneThreshold &&
                            data[i + 1] <= blackToneThreshold &&
                            data[i + 2] <= blackToneThreshold
                        ) {
                            data[i] = 0; // Vermelho
                            data[i + 1] = 0; // Verde
                            data[i + 2] = 0; // Azul
                        }

                        // branco em 100%
                        if (
                            data[i] >= whiteToneThreshold &&
                            data[i + 1] >= whiteToneThreshold &&
                            data[i + 2] >= whiteToneThreshold
                        ) {
                            data[i] = 255; // Vermelho
                            data[i + 1] = 255; // Verde
                            data[i + 2] = 255; // Azul
                        }

                        // brilho 100%
                        data[i] *= brightnessMultiplier; // Vermelho
                        data[i + 1] *= brightnessMultiplier; // Verde
                        data[i + 2] *= brightnessMultiplier; // Azul

                        // data[i] *= exposureMultiplier; // Vermelho
                        // data[i + 1] *= exposureMultiplier; // Verde
                        // data[i + 2] *= exposureMultiplier; // Azul
                    }
                    ctx.putImageData(imageData, 0, 0);
                }

                canvas.toBlob(
                    (blob) => {
                        let type = "image/jpeg";
                        if (file.type === "image/png") {
                            type = "image/png";
                        } else if (
                            file.type === "image/jpg" ||
                            file.type === "image/jpeg"
                        ) {
                            type = "image/jpeg";
                        }

                        const compressedFile = new File(
                            [blob],
                            file.name,
                            {
                                type: type,
                                lastModified: Date.now(),
                            }
                        );

                        resolve(compressedFile);
                    },
                    file.type,
                    0.7
                );
            };
        };
        reader.readAsDataURL(file);
    });
}

export function formatCpf(value){
    if (!value) return ''

    const digits = value.toString().replace(/\D/g, '').slice(0, 11)

    return digits
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
}

export function formatPhone(value){
    if(!value) return '';

    const digits = value.toString().replace(/\D/g,'').slice(0,11);

    return digits
        .replace(/(\d{0})(\d)/, '$1($2')
        .replace(/(\d{2})(\d)/, '$1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2')
}

export function formatCNH(value) {
    if (!value) return ''

    return value
        .toString()
        .replace(/[^a-zA-Z0-9]/g, '')
        .replace(/(\d{9})(\d)/, '$1-$2')
        .toUpperCase()
}

export function formatCnhType(value) {
    if (!value) return ''

    return value
        .toString()
        .replace(/[^a-zA-Z0-9]/g, '')
        .toUpperCase()
}

export function formatPlate(value) {
    if (!value) return ''

    return value
        .toString()
        .toUpperCase()
        .replace(/[^A-Z0-9]/g, '')
        .slice(0, 7)
}

