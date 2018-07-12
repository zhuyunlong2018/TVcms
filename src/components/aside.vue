<template>
    <aside class="sidebar f-r">
        <div class="msg">
            <h3>关注边泉</h3>
            <div class="content">
                <ul class="icon">
                    <li @mouseover="show_text" class="collect"><i class="glyphicon glyphicon-star-empty"></i></li>
                    <li @mouseover="show_text" class="email"><i class="glyphicon glyphicon-envelope"></i></li>
                    <li @mouseover="show_text" @click="$router.push('/msgborder')" class="message"><i
                            class="glyphicon glyphicon-comment"></i></li>
                    <li @mouseover="show_text" @click="_add_praise" class="praise"><i
                            class="glyphicon glyphicon-thumbs-up"></i></li>
                </ul>
                <p class="msg-text">{{ msg_text }}</p>
            </div>
        </div>
        <div class="msg">
            <h3>云标签</h3>
            <div class="content tag-content">
                <svg :width='width' :height='height' @mousemove='listener($event)'>
                    <a @click="_get_article_by_tag(tag.text)" v-for='(tag,index) in tags' :key='index'>
                        <text :x='tag.x' :y='tag.y' :font-size='20 * (600/(600-tag.z))'
                              :fill-opacity='((400+tag.z)/600)'>{{tag.text}}
                        </text>
                    </a>
                </svg>
            </div>
        </div>
        <div class="msg webdata">
            <h3>本站统计</h3>
            <div class="content">
                <div class="box box1">
                    <div class="name">
                        <h4>WebSiteName</h4>
                        <h5>bianquan</h5>
                    </div>
                    <p><i class="glyphicon glyphicon-text-color"></i></p>
                </div>
                <div class="box box2">
                    <div class="name">
                        <h4>start time</h4>
                        <h5>2018-01-23</h5>
                    </div>
                    <p><i class="glyphicon glyphicon-send"></i></p>
                </div>
                <div class="box box3">
                    <div class="name">
                        <h4>present time</h4>
                        <h5>{{now_time}}</h5>
                    </div>
                    <p><i class="glyphicon glyphicon-time"></i></p>
                </div>
                <div class="box box4">
                    <div class="name">
                        <h4>time of duration</h4>
                        <h5>{{how_long}} days</h5>
                    </div>
                    <p><i class="glyphicon glyphicon-calendar"></i></p>
                </div>
            </div>
        </div>
        <div class="msg neighbors">
            <h3>友情链接</h3>
            <div class="content">
                <ul>
                    <li v-for="(item,index) in all_neighbors" :key="index">
                        <a :href="item.nb_url" target="view_window">
                            {{item.nb_name}}</a>
                        <span><i class="glyphicon glyphicon-pushpin"></i></span>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>

    import {mapActions, mapState, mapMutations} from 'vuex';

    export default {
        data() {
            return {
                msg_text: '按control+d收藏本站',
                width: 250,//svg宽度
                height: 300,//svg高度
                RADIUS: 150,//球的半径
                speedX: Math.PI / 360,//球一帧绕x轴旋转的角度
                speedY: Math.PI / 360,//球-帧绕y轴旋转的角度
                tags: []
            }
        },
        methods: {
            ...mapActions(['add_praise', 'getPageCount', 'getPage']),
            ...mapMutations(['CHANGE_CRUMBS', 'changePage']),
            _add_praise: function () {
                let id = 0;
                this.add_praise(id);
            },
            show_text: function (e) {
                let element = e.target.className;
                switch (element) {
                    case 'glyphicon glyphicon-star-empty':
                        this.msg_text = '按control+d收藏本站';
                        break;
                    case 'glyphicon glyphicon-envelope':
                        this.msg_text = '给我发送邮件';
                        break;
                    case 'glyphicon glyphicon-comment':
                        this.msg_text = '累计获得' + this.webdata.comment + '条评论';
                        break;
                    case 'glyphicon glyphicon-thumbs-up':
                        this.msg_text = '累计获赞' + this.webdata.praise + '个';
                        break;
                }
            },
            stopProp: function (e) {
                e = e || event;
                e.stopPropagation();
            },
            rotateX(angleX) {
                var cos = Math.cos(angleX);
                var sin = Math.sin(angleX);
                for (let tag of this.tags) {
                    var y1 = (tag.y - this.CY) * cos - tag.z * sin + this.CY;
                    var z1 = tag.z * cos + (tag.y - this.CY) * sin;
                    tag.y = y1;
                    tag.z = z1;
                }
            },
            rotateY(angleY) {
                var cos = Math.cos(angleY);
                var sin = Math.sin(angleY);
                for (let tag of this.tags) {
                    var x1 = (tag.x - this.CX) * cos - tag.z * sin + this.CX;
                    var z1 = tag.z * cos + (tag.x - this.CX) * sin;
                    tag.x = x1;
                    tag.z = z1;
                }
            },
            listener(event) {//响应鼠标移动
                var x = event.clientX - this.CX;
                var y = event.clientY - this.CY;
                this.speedX = x * 0.0001 > 0 ? Math.min(this.RADIUS * 0.00002, x * 0.0001) : Math.max(-this.RADIUS * 0.00002, x * 0.0001);
                this.speedY = y * 0.0001 > 0 ? Math.min(this.RADIUS * 0.00002, y * 0.0001) : Math.max(-this.RADIUS * 0.00002, y * 0.0001);
            },
            _get_article_by_tag: function (tag) {
                let obj = {};
                obj.tag = tag;
                obj.title = '';
                this.CHANGE_CRUMBS(obj);
                this.changePage(0);
                this.getPageCount();
                this.getPage(0);
                this.$router.push('/');
            }
        },
        mounted() {
            setInterval(() => {
                this.rotateX(this.speedX);
                this.rotateY(this.speedY);
            }, 17)

        },
        created() {
            clearInterval(make_cloud);
            let make_cloud = setInterval(() => {
                if (this.options.length !== 0) {
                    let tags = [];
                    let options = this.options;
                    options = options.concat(this.options);
                    options = options.concat(this.options);
                    for (let i = 0; i < options.length; i++) {
                        let tag = {};
                        let k = -1 + (2 * (i + 1) - 1) / options.length;
                        let a = Math.acos(k);
                        let b = a * Math.sqrt(options.length * Math.PI)//计算标签相对于球心的角度
                        tag.text = options[i].tag;
                        tag.x = this.CX + this.RADIUS * Math.sin(a) * Math.cos(b);//根据标签角度求出标签的x,y,z坐标
                        tag.y = this.CY + this.RADIUS * Math.sin(a) * Math.sin(b);
                        tag.z = this.RADIUS * Math.cos(a);
                        tags.push(tag);
                    }
                    this.tags = tags;
                    clearInterval(make_cloud);
                }
            }, 2000)

        },
        computed: {
            ...mapState(['webdata', 'now_time', 'how_long', 'all_neighbors', 'options']),
            CX() {//球心x坐标
                return this.width / 2;
            },
            CY() {//球心y坐标
                return this.height / 2;
            }
        }
    }
</script>


<style scoped>


    /* 网站内容-侧边区 */
    main aside {
        width: 26%;
    }

    main aside .msg {
        width: 100%;
        text-align: center;
        margin: 15px 0;
        background: #fff;
        border-radius: 10px;
        box-shadow: 3px 3px 8px 2px #ccc;
    }

    main aside .msg .icon {
        height: 90px;
    }

    .msg-text {
        font-size: 20px;
        color: #729;
    }

    main aside .msg .icon li {
        display: inline-block;
        width: 22%;
        cursor: pointer;
        font-size: 40px;
        transition: all 0.5s;
    }

    main aside .msg .icon li:nth-child(1) {
        color: #559;
    }

    main aside .msg .icon li:nth-child(2) {
        color: #977;
    }

    main aside .msg .icon li:nth-child(3) {
        color: #595;
    }

    main aside .msg .icon li:nth-child(4) {
        color: #900;
    }

    main aside .msg .icon li:hover {
        font-size: 48px;
        margin-top: 10px;
        color: rgb(233, 157, 204);
    }

    main aside .msg h3 {
        margin: 0;
        padding: 10px 0;

    }

    main aside .msg .content {
        width: 80%;
        margin: 0 auto;
        border-top: 1px solid #aaa;
    }

    main aside .webdata .content {
        width: 100%;
        font-size: 1.2em;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 6px 6px 24px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .webdata .content .box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        height: 50px;
        padding: 0px 20px;
        transition: all 1s;
        color: #000;
        background-color: #fff;
        box-shadow: 0 1px 2px 3px rgba(0, 0, 0, 0.2);
    }

    .webdata .content .box .name {
        float: left;
        /* width: 150px; */
    }

    .webdata .content .box .name h4,
    .webdata .content .box .name h5 {
        font-weight: 300;
    }

    .webdata .content .box .name h5 {
        font-size: 0em;
        line-height: 1.5;
        transition: all 0.3s;
    }

    .webdata .content .box p {
        float: right;
        height: 50px;
        line-height: 50px;
        font-size: 0.8em;
        font-weight: 300;
    }

    .webdata .content .box:hover {
        color: rgb(0, 34, 185);
        transition: all 0.5s;
        height: 80px;
    }

    .webdata .content .box:hover p {
        height: 80px;
        line-height: 80px;
    }

    .webdata .content .box:hover p i {
        transition: all 0.3s;
        font-size: 2em;
    }

    .webdata .content .box:hover .name h5 {
        transition: all 0.3s;
        font-size: 0.7em;
    }

    main aside .msg:nth-child(2) {
        max-height: 570px;
    }

    main aside .msg:nth-child(4) {
        max-height: 375px;
    }

    .neighbors .content ul li {
        padding: 5px;
        width: 100%;
    }

    .neighbors .content ul li a {
        text-decoration: none;
    }

    .tag-content {
        height: 300px;
        overflow: hidden;
    }

    .tag-content a {
        cursor: pointer;
        text-decoration: none;
    }

    @media screen and (max-width: 900px) {
        .webdata .content .box .name {
            width: 100 px\9 \0;
        }
    }

    @media screen and (max-width: 768px) {
        main aside {
            display: none;
            opacity: 0;
        }
    }

    @media screen and (min-width: 768px) {
        main aside .msg .content {
            width: 95%;
        }

        main aside .msg .icon li {
            margin: 20px 1px 0 1px;
            font-size: 35px;
        }

        main aside .msg .icon li:hover {
            font-size: 42px;
        }

        main aside .msg .icon {
            height: 70px;
        }

        .msg-text {
            font-size: 15px;
        }

    }

    @media screen and (min-width: 1020px) {
        main aside .msg .icon li {
            margin: 20px 1px 0 1px;
            font-size: 45px;
        }

        main aside .msg .icon li:hover {
            font-size: 50px;
        }

        main aside .msg .icon {
            height: 85px;
        }

        .msg-text {
            font-size: 18px;
        }
    }


</style>
