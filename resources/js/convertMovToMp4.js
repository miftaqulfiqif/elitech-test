import { FFmpeg } from "@ffmpeg/ffmpeg";
import { fetchFile, toBlobURL } from "@ffmpeg/util";

const ffmpegRef = new FFmpeg();

async function convertMovToMp4(file) {
    const ffmpeg = ffmpegRef.current;
    await ffmpeg.load();
    ffmpeg.FS("writeFile", "input.mov", await fetchFile(file));
    await ffmpeg.run("-i", "input.mov", "output.mp4");

    const data = ffmpeg.FS("readFile", "output.mp4");
    const url = URL.createObjectURL(
        new Blob([data.buffer], { type: "video/mp4" })
    );

    return url;
}

export { convertMovToMp4 };
