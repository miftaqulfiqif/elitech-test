import { createFFmpeg, fetchFile } from "@ffmpeg/ffmpeg";

const ffmpeg = createFFmpeg({ log: true });

async function convertMovToMp4(file) {
    await ffmpeg.load();
    ffmpeg.FS("writeFile", "input.mov", await fetchFile(file));
    await ffmpeg.run("-i", "input.mov", "output.mp4");

    const data = ffmpeg.FS("readFile", "output.mp4");
    const url = URL.createObjectURL(
        new Blob([data.buffer], { type: "video/mp4" })
    );

    return url;
}
