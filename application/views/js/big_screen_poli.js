import React from "react";
import ReactDOM from 'react-dom';
import axios from "axios";
import { Howl, Howler } from 'howler';
import jPlayer from "react-jplayer/lib/components/jPlayer/jPlayer";
import $ from "../../../node_modules/jquery/dist/jquery";
import ReactPlayer from 'react-player'

export default class BigScreenPoli extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            playing: true,
            repeat: localStorage.getItem('repeat'),
            data_que: { loket_name: "", que_kode: "", call_at: null },
            video: { width: '', height: '' },
            current_count: 0, intervalId: null,
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
        var intervalId = setInterval(() => this.timer(), 100);
        this.setState({ intervalId });
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
            this.setState({ current_count: newCount });
        }
    }
    readEntry() {

        Promise.resolve(axios({ method: 'post', url: window.origin + '/index.php/big_screen/read_entry_poli' }))
            .then((response) => {
                console.log(response.data);
                if (response.data.t > 0) {
                    let que = this.state.data_que;
                    que.loket_name = response.data.loket_name;
                    que.que_kode = response.data.que_kode;

                    this.setState({ que });
                    if (this.state.data_que.que_kode !== "" && this.state.playing == true) {
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
            setTimeout(() => {
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
        }, 2000);
    }

    ending2() {
        localStorage.setItem('repeat', false);
        let loket = this.state.data_que.loket_name;
        let poli = new Audio(window.origin + '/assets/voices/poli/' + loket.toLowerCase(this.state.data_que.loket_name) + '.mp3');
        poli.play();
        setTimeout(() => {
            this.setState({ playing: true });
        }, 1200)
    }

    text_to_speech(kode, cek) {
        let code = parseInt(kode)
        let angka = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11"];
        if (code < 12) {
            let voice = new Audio(window.origin + '/assets/voices/' + angka[code] + '.mp3');
            voice.play();
            if (cek > 12) {
                return;
            }
            voice.onloadedmetadata = () => {
                setTimeout(() => {
                    this.ending1();
                }, parseFloat(Math.round(voice.duration) + '000'));
            }
        } else if (code < 20) {
            let voice = new Audio(window.origin + '/assets/voices/' + angka[code - 10] + '.mp3');
            voice.play();
            setTimeout(() => {
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
                    <div className="col-md-5" style={{ paddingLeft: '0px' }}>
                        <div className="panel panel-danger antriWrap" style={{ borderWidth: '10px', height: this.state.video.height + 30 }}>
                            <div className="panel-heading" style={{ textAlign: 'center' }}>
                                <strong style={{ fontSize: '30px' }} className="loket_name">{this.state.data_que.loket_name}</strong>
                            </div>
                            <div className="panel-body">
                                <div className="nomorAntri">
                                    {this.state.data_que.que_kode == "" ? null : this.state.data_que.que_kode}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div className="col-md-7" style={{ paddingRight: '0px' }}>
                        <div className="panel panel-danger" style={{ borderWidth: '10px', height: this.state.video.height + 50 }}>
                            <div className="panel-body videoWrapper">

                                <div id="jp_container_N">
                                    <ReactPlayer
                                        url={window.origin + '/assets/video/Jenis_Pelayanan_PKM_Nagreg.mp4'}
                                        width={'100%'}
                                        height={'100%'}
                                        playing={true}
                                        volume={this.state.playing == false ? 0 : 1}
                                        loop={true}

                                        onPlay={() => {
                                            let video_height = document.querySelector('#jp_container_N').clientHeight;
                                            let video_width = document.querySelector('.videoWrapper').clientWidth - 30;

                                            let video = this.state.video;
                                            video.width = video_width;
                                            video.height = video_height;
                                            this.setState({ video });

                                        }}
                                    />
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