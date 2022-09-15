import React from "react";
import ReactDOM from 'react-dom';
import axios from "axios";
import {Howl, Howler} from 'howler';

export default class BigScreenPoli extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            playing: true,
            repeat: localStorage.getItem('repeat'),
            data_que: { loket_name: "", que_kode: "", call_at:null},
            current_count : 0, intervalId : null,
        }

        this.opening = this.opening.bind(this);
        this.ending1 = this.ending1.bind(this);
        this.ending2 = this.ending2.bind(this);
        this.text_to_speech = this.text_to_speech.bind(this);
        this.readEntry = this.readEntry.bind(this);
        this.timer = this.timer.bind(this);
        this.getMedia = this.getMedia.bind(this);
    }

    componentDidMount() { 
        //this.getMedia()
       // window.open("chrome://settings");
        var intervalId = setInterval(() => this.timer(),100);
        this.setState({intervalId});
        this.readEntry();
    }
    
   async getMedia() {
       let stream = null;

        try {
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            console.log(stream);
        } catch (err) {
            console.log(err);
        }
    }
    
    timer() {
        let newCount = this.state.current_count + 1;
        if (newCount >= 30) {
            this.setState({ current_count: 0 });
            this.readEntry();
        } else {
            this.setState({current_count:newCount});
        }
    }
    readEntry() {
      
             Promise.resolve(axios({ method: 'post', url:window.origin + '/index.php/big_screen/read_entry_poli' }))
            .then((response) => {
                console.log(response.data);
                if (response.data.t > 0) {
                    let que = this.state.data_que;
                    que.loket_name = response.data.loket_name;
                    que.que_kode = response.data.que_kode;
                   
                    this.setState({ que });
                    if (this.state.data_que.que_kode !== "" && this.state.playing == true) {
                        // if (this.state.data_que.call_at !== response.data.call_at) {
                        //     this.opening(this.state.data_que.que_kode, 0);
                        //     que.call_at = response.data.call_at;
                        //     this.setState({ que });
                        // }
                        this.opening(this.state.data_que.que_kode, 0);
                    }
                }
                
            }).catch((error) => {
                console.log(error);
            });
        
      
    }
    
    opening(kode, code) {
        this.setState({ playing: false });
      
        let opening = new Audio();
        opening.src = window.origin + '/assets/voices/' + 'opening.mp3';
        opening.autoplay = true;
            opening.play();
            opening.onloadedmetadata = () => {
                    setTimeout( () => {
                        this.text_to_speech(kode, code)
                    }, parseFloat(Math.round(opening.duration) + '000'));
                }
        
    }

    ending1() {
        let menuju = new Audio(window.origin + '/assets/voices/' + 'silahkan_menuju.mp3');
        menuju.autoplay = true;
            menuju.play();
            setTimeout(() => {
                this.ending2();
                this.setState({ playing: true });
            }, 2000);
    }
    
    ending2() {
        localStorage.setItem('repeat', false);
        let loket = this.state.data_que.loket_name;
            if (loket === 'Umum') {
                let poli_umum = new Audio(window.origin + '/assets/voices/' + 'poli_umum.mp3')
                poli_umum.play();
            } else if (loket == 'Mtbs') {
                let poli_umum = new Audio(window.origin + '/assets/voices/poli/' + 'poli_mtbs.mp3')
                poli_umum.play();
            } else if (loket == 'Kia') {
                let poli_umum = new Audio(window.origin + '/assets/voices/poli/' + 'poli_kia.mp3')
                poli_umum.play();
            } else if (loket == 'Gigi') {
                let poli_umum = new Audio(window.origin + '/assets/voices/poli/' + 'poli_gigi.mp3')
                poli_umum.play();
            } else if (loket == 'Askulap') {
                let poli_umum = new Audio(window.origin + '/assets/voices/poli/' + 'poli_askulap.mp3')
                poli_umum.play();
            }
        this.setState({ playing: true });
    }
    
    text_to_speech(kode,cek) {
        let code = parseInt(kode)
            let angka = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11"];
            if (code < 12) {
                let voice = new Audio(window.origin + '/assets/voices/' + angka[code] + '.mp3');
                voice.play();
                if (cek > 12) {
                    return;
                }
                voice.onloadedmetadata = () => {
                    setTimeout( () => {
                        this.ending1();
                    }, parseFloat(Math.round(voice.duration) + '000'));
                }
            } else if (code < 20) {
                let voice = new Audio(window.origin + '/assets/voices/' + angka[code - 10] + '.mp3');
                voice.play();
                setTimeout( () => {
                    let voice2 = new Audio(window.origin + '/assets/voices/' + 'belas.mp3');
                    voice2.play();

                    voice2.onloadedmetadata = () => {
                        setTimeout(() => {
                            this.ending1();
                        }, parseFloat(Math.round(voice2.duration) + '000'));
                    }

                }, 800);
                return true
            } else if (code < 100) {
                this.text_to_speech(code / 10, kode);
                setTimeout(() => {
                    let voice2 = new Audio(window.origin + '/assets/voices/' + 'puluh.mp3');
                    voice2.play();

                    if (code % 10 == 0) {
                        voice2.onloadedmetadata = () => {
                            setTimeout(() => {
                                this.ending1();
                            }, parseFloat(Math.round(voice2.duration) + '000'))
                        }
                    }
                    if (code % 10 > 0) {
                        setTimeout(() => {
                            this.text_to_speech(code % 10, 0);
                        }, 800)
                    }
                }, 800);
                return true
            } else if (code < 200) {
                if (code == 100) {
                    let voice = new Audio(window.origin + '/assets/voices/' + '100.mp3');
                    voice.play();
                    voice.onloadedmetadata = () => {
                        setTimeout(() => {
                            this.ending1();
                        }, parseFloat(Math.round(voice.duration) + '000'));
                    }
                } else {
                    let voice = new Audio(window.origin + '/assets/voices/' + '100.mp3');
                    voice.play();
                    voice.onloadedmetadata = () => {
                        setTimeout(() => {
                            this.text_to_speech(code - 100);
                        }, parseFloat(Math.round(voice.duration) + '000'));
                    }
                }
            } else if (code < 1000) {
                this.text_to_speech(code / 100, kode);
                setTimeout(() => {
                    let voice = new Audio(window.origin + '/assets/voices/' + 'ratus.mp3');
                    voice.play();
                    if (code % 100 == 0) {
                        voice.onloadedmetadata = () => {
                            setTimeout(() => {
                               this.ending1();
                            }, parseFloat(Math.round(voice.duration) + '000'));
                        }
                    }
                    if (code % 100 > 0) {

                        setTimeout(() => {
                            this.text_to_speech(code % 100, 0);
                        }, 800)
                    }
                }, 800)
                return true
            }
    }

    render() {
        return (
            <> 
                <div className="content">
                    <div className="col-md-5" style={{paddingLeft:'0px'}}>
                        <div className="panel panel-danger antriWrap" style={{borderWidth:'10px'}}>
                            <div className="panel-heading" style={{textAlign:'center'}}>
                                <strong style={{ fontSize: '30px' }} className="loket_name">Poli {this.state.data_que.loket_name}</strong>
                            </div>
                            <div className="panel-body">
                                <div className="nomorAntri">
                                   {this.state.data_que.que_kode == "" ? null : this.state.data_que.que_kode}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div className="col-md-7" style={{paddingRight:'0px'}}>
                        <div className="panel panel-danger">
                            <div className="panel-body videoWrapper">

                                <div id="jp_container_N" className="jp-video jp-video-270p" role="application" aria-label="media player">
                                    <div className="jp-type-playlist">
                                        <div id="jquery_jplayer_N" className="jp-jplayer"></div>
                                        <div className="jp-gui">
                                            <div className="jp-video-play">
                                                <button className="jp-video-play-icon" role="button" tabIndex="0">play</button>
                                            </div>
                                            <div className="jp-interface" style={{display:'none'}}>
                                                <div className="jp-progress">
                                                    <div className="jp-seek-bar">
                                                        <div className="jp-play-bar"></div>
                                                    </div>
                                                </div>
                                                <div className="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                                <div className="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                                <div className="jp-controls-holder">
                                                    <div className="jp-controls">
                                                        <button className="jp-previous" role="button" tabIndex="0">previous</button>
                                                        <button className="jp-play" role="button" tabIndex="0">play</button>
                                                        <button className="jp-next" role="button" tabIndex="0">next</button>
                                                        <button className="jp-stop" role="button" tabIndex="0">stop</button>
                                                    </div>
                                                    <div className="jp-volume-controls">
                                                        <button className="jp-mute" role="button" tabIndex="0">mute</button>
                                                        <button className="jp-volume-max" role="button" tabIndex="0">max volume</button>
                                                        <div className="jp-volume-bar">
                                                            <div className="jp-volume-bar-value"></div>
                                                        </div>
                                                    </div>
                                                    <div className="jp-toggles">
                                                        <button className="jp-repeat" role="button" tabIndex="0">repeat</button>
                                                        <button className="jp-shuffle" role="button" tabIndex="0">shuffle</button>
                                                        <button className="jp-full-screen" role="button" tabIndex="0">full screen</button>
                                                    </div>
                                                </div>
                                                <div className="jp-details">
                                                    <div className="jp-title" aria-label="title">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="jp-playlist" style={{display:'none'}}>
                                            <ul>
                                                The method Playlist.displayPlaylist() uses this unordered list
                                                <li>&nbsp;</li>
                                            </ul>
                                        </div>
                                        <div className="jp-no-solution">
                                            <span>Update Required</span>
                                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>


                
            </>
        )
    }
}

if (document.getElementById('big_screen_poli')) {
    ReactDOM.render(<BigScreenPoli />, document.getElementById('big_screen_poli'));
}