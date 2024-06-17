/reproductor/

const audio = document.querySelector("audio");
const songTitle = document.getElementById("songTitle");
const play = document.getElementById("play");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const current_time = document.getElementById("current_time");
const current_audio = document.getElementById("current_audio");
const progressContainer = document.querySelector(".progress_container");
const progress = document.getElementById("progress");

const songs = ["Fine Line", "Persona 3", "Your Affection"];

let audioIndex = 0;

loadAudio(songs[audioIndex])

function loadAudio(song) {
  songTitle.textContent = song;
  audio.src = `audio/${song}.mp3`;

  audio.addEventListener("loadedmetadata", () => {
    timeSong(audio.duration, current_audio);
  });
}

function playSong() {
  play.classList.add("play");

  const icon = play.querySelector("i.fas");
  icon.classList.remove("fa-play");
  icon.classList.add("fa-pause");

  audio.play();

}

function pauseSong() {
  play.classList.remove("play");

  const icon = play.querySelector("i.fas");
  icon.classList.remove("fa-pause");
  icon.classList.add("fa-play");

  audio.pause();

}

function prevSong() {
  audioIndex--

  if (audioIndex < 0) {
    audioIndex = songs.length - 1;
  }

  loadAudio(songs[audioIndex]);
  playSong();

}
function nextSong() {
  audioIndex++

  if (audioIndex > songs.length - 1) {
    audioIndex = 0
  }

  loadAudio(songs[audioIndex]);
  playSong();

}

function updateBarPorgress(e) {
  const { duration, currentTime } = e.srcElement;

  const progressPercent = (currentTime / duration) * 100;

  progress.style.width = `${progressPercent}%`;

}

function setProgress(e) {
  const width = this.clientWidth;
  const clickPosition = e.offsetX;
  const duration = audio.duration;

  audio.currentTime = (clickPosition / width) * duration;
}

function timeSong(audio, element) {

  const totalSeconds = Math.round(audio);
  const minutes = Math.floor(totalSeconds / 60);
  const seconds = totalSeconds % 60; 
  
  element.textContent = `${minutes}:${seconds.toString().padStart(2, "0")}`;
} 

play.addEventListener("click", () => {
  const isPlaying = play.classList.contains("play");

  if (!isPlaying) {
    playSong();
  } else {
    pauseSong();
  }
});

prev.addEventListener("click", prevSong);
next.addEventListener("click", nextSong);

audio.addEventListener("timeupdate", (e) => {
  updateBarPorgress(e)
  timeSong(audio.currentTime, current_time);
});
const circle = document.querySelector(".progress-ring__circle");
const radius = circle.r.baseVal.value;
const circumference = radius * 2 * Math.PI;

circle.style.strokeDasharray = circumference;
circle.style.strokeDashoffset = circumference;

function setProgress(percent) {
  const offset = circumference - (percent / 100) * circumference;
  circle.style.strokeDashoffset = offset;
}

const focusTimeInput = document.querySelector("#focusTime");
const breakTimeInput = document.querySelector("#breakTime");
const pauseBtn = document.querySelector(".pause");

focusTimeInput.value = localStorage.getItem("focusTime");
breakTimeInput.value = localStorage.getItem("breakTime");

document.querySelector("form").addEventListener("submit", (e) => {
  e.preventDefault();
  localStorage.setItem("focusTime", focusTimeInput.value);
  localStorage.setItem("breakTime", breakTimeInput.value);
});

document.querySelector(".reset").addEventListener("click", () => {
  startBtn.style.transform = "scale(" + 1 + ")";
  clearTimeout(initial);
  setProgress(0);
  mindiv.textContent = 0;
  secdiv.textContent = 0;
});

pauseBtn.addEventListener("click", () => {
  if (paused === undefined) {
    return;
  }
  if (paused) {
    paused = false;
    initial = setTimeout("decremenT()", 60);
    pauseBtn.textContent = "pause";
    pauseBtn.classList.remove("resume");
  } else {
    clearTimeout(initial);
    pauseBtn.textContent = "resume";
    pauseBtn.classList.add("resume");
    paused = true;
  }
});

const elements = {
    el: document.querySelector(".clock"),
    
    mindiv: document.querySelector(".mins"),
    secdiv: document.querySelector(".secs"),
    startBtn: document.querySelector(".start")
  };
  
  localStorage.setItem("btn", "focus");
  
  const initialState = {
    initial: null,
    totalsecs: 0,
    perc: 0,
    paused: false,
    mins: 0,
    seconds: 0
  };
  
  for (let key in elements) {
    if (Object.prototype.hasOwnProperty.call(elements, key)) {
      window[key] = elements[key];
    }
  }
  
  for (let key in initialState) {
    if (Object.prototype.hasOwnProperty.call(initialState, key)) {
      window[key] = initialState[key];
    }
  }
  
  startBtn.addEventListener("click", () => {
    let btn = localStorage.getItem("btn");
  
    if (btn === "focus") {
      mins = +localStorage.getItem("focusTime") || 1;
    } else {
      mins = +localStorage.getItem("breakTime") || 1;
    }
  
    seconds = mins * 60;
    totalsecs = mins * 60;
    setTimeout(decremenT(), 60);
    startBtn.style.transform = "scale(" + 0 + ")";
    paused = false;
  });
  
  function decremenT() {
    mindiv.textContent = Math.floor(seconds / 60);
    secdiv.textContent = seconds % 60 > 9 ? seconds % 60 : "0:" + seconds % 60;
    if (circle && circle.classList.contains("danger")) {
      circle.classList.remove("danger");
    }
  
    if (seconds > 0) {
      perc = Math.ceil(((totalsecs - seconds) / totalsecs) * 100);
      setProgress(perc);
      seconds--;
      initial = window.setTimeout("decremenT()", 1000);
      if (seconds < 10) {
        if (circle) {
          circle.classList.add("danger");
        }
      }
    } else {
      mins = 0;
      seconds = 0;
      bell.play();
      let btn = localStorage.getItem("btn");
  
      if (btn === "focus") {
        startBtn.textContent = "start break";
        startBtn.classList.add("break");
        localStorage.setItem("btn", "break");
      } else {
        startBtn.classList.remove("break");
        startBtn.textContent = "start focus";
        localStorage.setItem("btn", "focus");
      }
      startBtn.style.transform = "scale(" + 1 + ")";
    }
  }

const darkMode = document.querySelector(".dark-mode");
const body = document.body;

darkMode.addEventListener("click",()=>{
    body.classList.toggle("active");
});

