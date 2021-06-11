import wave, math, contextlib
import speech_recognition as sr
from moviepy.editor import AudioFileClip

transcribed_audio_file_name = "my_output.wav"
#Hard coded video file to transcribe
zoom_video_file_name = "COS overview video.mov"

#Converts video to audio (specifically .wav format)
audioclip = AudioFileClip(zoom_video_file_name)
audioclip.write_audiofile(transcribed_audio_file_name)

#Now we turn this audio file into text
#10MB limit for each request sent to the API
#Need to first know duration of audio file so you can break it into chunks
#The with statement obtains the num of frames and the framerate
#Finally it calculates the frame rate

with contextlib.closing(wave.open(transcribed_audio_file_name,'r')) as f:
    frames = f.getnframes()
    rate = f.getframerate()
    duration = frames / float(rate)
total_duration = math.ceil(duration / 60)
r = sr.Recognizer()


#Now we use Google to translate those audio chunks to text
#The offset is the position in a read/write of a txt file

for i in range(0, total_duration):
    with sr.AudioFile(transcribed_audio_file_name) as source:
        audio = r.record(source, offset=i*60, duration=60)
    f = open("transcription.txt", "w")
    f.write(r.recognize_google(audio,language = 'en-us'))
    f.write(" ")
f.close()
