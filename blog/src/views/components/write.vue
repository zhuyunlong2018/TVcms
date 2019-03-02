<template>
  <div class="main" @click="closeBox">
    <div class="write">
      <div class="center clearfix">
        <div class="title-top">
          <input
            class="form-control title"
            type="text"
            name="title"
            v-model="article.a_title"
            placeholder="标题"
          >
          <div class="c-dropdown">
            <span class="c-button c-button-dropdown" @click="showTags">{{article.tag.tag_name}}</span>
            <transition name="show-tags">
              <ul class="c-dropdown__list" v-show="tags_box">
                <li
                  class="c-dropdown__item"
                  v-for="tag in tags"
                  :key="tag.tag_id"
                  :value="tag.tag_id"
                  @click="selectTag(tag)"
                >{{ tag.tag_name }}</li>
              </ul>
            </transition>
          </div>
        </div>
        <div class="markdown f-l editor">
          <div>
            <textarea
              class="outline"
              v-model="article.outline"
              cols="70"
              rows="3"
              placeholder="文章概要（请控制在100字左右）"
            ></textarea>
          </div>
          <markdown-editor
            v-model="article.a_content"
            ref="markdwonEditor"
            :configs="configs"
            :highlight="true"
            preview-class="markdown-body"
          ></markdown-editor>
        </div>
        <div class="file f-r">
          <div class="imgBox">
            <div class="imgContainer background-box">
              <img v-show="article.a_img" :src="article.a_img">
              <p v-show="!article.a_img" class="background-notice">暂无封面</p>
              <p>文章封面</p>
            </div>
          </div>
          <div class="inputBox">
            <input
              type="file"
              @change="fileImage"
              title="请选择图片"
              id="file"
              multiple
              accept="image/png, image/jpg, image/gif, image/JPEG"
            >点击选择图片
          </div>
          <div class="imgBox" v-show="imgs.length">
            <div v-for="(img,index) in imgs" :key="img.name" class="imgContainer">
              <img :src="img.url" alt>
              <p @click="remove(index)">删除</p>
            </div>
          </div>
          <button type="button" class="btn btn-info" @click="upImgs">立即上传</button>
          <div class="imgBox" v-show="article.images.length">
            <p class="add_notice">加入正文</p>
            <div v-for="img in article.images" :key="img.image" class="imgContainer">
              <img :src="img.image" alt>
              <p class="set-background" @click="setBackground(img)">设为封面</p>
              <p @click="addImgArticle(img)">加入正文</p>
            </div>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-success" v-if="create" @click="addArticle">发布文章</button>
      <button type="button" class="btn btn-danger" v-if="!(create)" @click="updateArticle">更新文章</button>
    </div>
  </div>
</template>

<script>
// import markdownEditor from 'vue-simplemde/src/markdown-editor';
import { mapMutations, mapGetters } from 'vuex'
import { getOne, addArticle, updateArticle } from '@/api/article'
import { getList } from '@/api/tags'
import { upBase64 } from '@/api/file'
export default {
  data() {
    return {
      article: {
        a_content: '',
        a_id: 0,
        a_img: '',
        a_title: '',
        outline: '',
        tag: {
          tag_id: 1,
          tag_name: '生活随笔',
          create_time: '1970-01-01 08:00:00'
        },
        images: [],
        tag_id: 1,
        user_id: 0
      },
      create: true,
      tags: [],
      tags_box: false, // 控制标签选项盒子显示或隐藏
      imgs: [], // 图片上传预览框中的图片地址
      images: [], // 传递到后台的图片地址
      savedImgs: [], // 本次要保存的图片名集合
      configs: {
        status: false,
        spellChecker: false,
        placeholder: '内容'
      }
    }
  },
  methods: {
    ...mapMutations(['SHOW_ALERT']),
    getOne(id) {
      getOne(id).then(response => {
        this.article = response.data.data
      })
    },
    getTags() {
      getList('').then(response => {
        this.tags = response.data.data
      })
    },
    showTags() {
      this.tags_box = true
      this.stopProp()
    },
    selectTag(tag) {
      this.article.tag = tag
      this.article.tag_id = tag.tag_id
      this.tags_box = false
    },
    stopProp(e) {
      e = e || event
      e.stopPropagation()
    },
    addArticle() {
      this.article.imgs = this.savedImgs
      addArticle(this.article).then(response => {
        this.$router.push('/admin/editor')
      })
    },
    updateArticle() {
      this.article.imgs = this.savedImgs
      updateArticle(this.article).then(respoonse => {
        this.$router.push('/admin/editor')
      })
    },
    closeBox() {
      this.tags_box = false
    },
    addImgArticle(img) {
      const content = this.article.a_content
      this.article.a_content = content + '![](' + img.image.replace(/\\/g, '/') + ')'
    },
    setBackground(img) {
      this.article.a_img = img.image
    },
    fileImage(e) {
      const _this = this
      const file = e.target.files
      // console.log(file[0].name);
      if (this.imgs.length > 9 || this.imgs.length + file.length > 9) {
        this.SHOW_ALERT('图片超过9九张，请分多次上传')
        return
      }
      for (let i = 0; i < file.length; i++) {
        if (this.imgs.length > 0) {
          for (let j = 0; j < this.imgs.length; j++) {
            if (file[i].name === this.imgs[j].name) {
              this.SHOW_ALERT('请不要选择重复图片')
              return
            } else {
              continue
            }
          }
        }
        const imgSize = file[i].size / 1024
        if (imgSize > 500) {
          this.SHOW_ALERT('请上传大小不要超过500KB的图片')
          continue
        } else {
          const reader = new FileReader()
          reader.readAsDataURL(file[i]) // 读出 base64
          reader.onloadend = function() {
            // 图片的 base64 格式, 可以直接当成 img 的 src 属性值
            const dataURL = reader.result
            const obj = {}
            obj.url = dataURL
            obj.name = file[i].name
            _this.imgs.push(obj) // 将base64图片数据存入预览用的数组
            _this.images.push(dataURL) // 将base64图片数据存入发送服务端用的数组
          }
        }
      }
    },
    upImgs: function() {
      if (this.imgs.length === 0) {
        this.SHOW_ALERT('请选择要上传图片')
        return
      }
      const data = {
        imgs: this.images,
        path: 'article'
      }
      upBase64(data).then(response => {
        const data = response.data.data
        this.imgs = []
        this.images = []
        this.savedImgs = this.savedImgs.concat(data.name)
        const images = []
        for (const v of data.path) {
          images.push({ image: v })
        }
        const oldImages = this.article.images
        this.article.images = oldImages.concat(images)
      })
    },
    remove: function(index) {
      this.imgs.splice(index, 1)
      this.images.splice(index, 1)
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  mounted() {
    this.getTags()
    const id = this.$route.params.id
    if (id) {
      this.create = false
      this.getOne(id)
    }
    this.article.user_id = this.user.user_id
  }
}
</script>

<style scoped>
/*@import '~simplemde/dist/simplemde.min.css';*/

.main {
  width: 100%;
  min-height: 800px;
}
.write {
  width: 90%;
  margin: 0 auto;
}
.title-top {
  margin: 20px 0;
}
.title-top .title,
.center .markdown {
  width: 70%;
  font-size: 18px;
  display: inline-block;
}
.title-top .title {
  width: 50%;
}
.center .file {
  width: 28%;
  text-align: center;
  padding: 20px;
  margin-left: 20px;
  border: 1px solid #ccc;
  background: #fff;
  border-radius: 10px;
}
.main .write .markdown-editor .CodeMirror,
.main .write .markdown-editor .CodeMirror-scroll {
  min-height: 500px;
}

.write
  .CodeMirror
  .cm-spell-error:not(.cm-url):not(.cm-comment):not(.cm-tag):not(.cm-word) {
  background: rgba(250, 250, 250, 0);
}
.write > button {
  margin-top: 20px;
  margin-bottom: 100px;
}
.outline {
  width: 100%;
}

.inputBox {
  width: 100%;
  height: 40px;
  border: 1px solid cornflowerblue;
  color: cornflowerblue;
  border-radius: 20px;
  position: relative;
  text-align: center;
  line-height: 40px;
  overflow: hidden;
  font-size: 16px;
}
.inputBox input {
  width: 114%;
  height: 40px;
  opacity: 0;
  cursor: pointer;
  position: absolute;
  top: 0;
  left: -14%;
}
.imgBox {
  text-align: center;
}
.imgContainer {
  border: 1px solid rgba(0, 0, 0, 0.3);
  display: inline-block;
  width: 45%;
  height: 150px;
  margin-left: 1%;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
  margin-top: 20px;
  box-sizing: border-box;
}

.imgBox .background-box {
  border: 1px solid rgba(0, 0, 0, 0.3);
  margin-left: 0;
  margin-right: 0;
  margin-top: 0;
  margin-bottom: 10px;
  width: 100%;
}
.imgContainer img {
  width: 100%;
  height: 100%;
  cursor: pointer;
}
.imgContainer p {
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 100%;
  height: 30px;
  background: rgba(0, 0, 0, 0.5);
  text-align: center;
  line-height: 30px;
  color: white;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  display: none;
}
.imgContainer p.background-notice {
  top: 0;
  bottom: 0;
  margin: auto;
  color: #333;
  background-color: #fff;
  font-size: 20px;
  display: block;
}
.imgContainer p.set-background {
  position: absolute;
  top: -1px;
  left: 0;
  width: 100%;
  height: 30px;
  background: rgba(0, 0, 0, 0.5);
  text-align: center;
  line-height: 30px;
  color: white;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  display: none;
}
.imgContainer:hover p {
  display: block;
}

.add_notice {
  margin-top: 20px;
  border-bottom: 1px solid #930;
  color: #930;
}

.btn-info,
.btn-warning {
  margin-top: 20px;
  width: 100%;
}

.c-dropdown {
  position: relative;
  display: inline-block;
  text-align: left;
}

.c-dropdown__list {
  margin: 5px 0 0 0;
  padding: 6px 0;
  list-style: none;
  position: absolute;
  top: 125%;
  left: 0;
  width: 100%;
  z-index: 9999;
  border: 1px solid rgb(184, 177, 177);
  /* opacity: 0;
  visibility: hidden; */
  border-radius: 3px;
  background: #fff;
}
.c-dropdown.is-open .c-dropdown__list {
  opacity: 1;
  visibility: visible;
  top: 100%;
}

.c-dropdown__item {
  padding: 6px 12px;
  font-size: 14px;
  line-height: 20px;
  cursor: pointer;
  color: #434a54;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.c-dropdown__item:hover {
  background-color: #e6e9ed;
}
.c-button {
  margin-left: 20px;
  margin: 0;
  border: 0;
  overflow: visible;
  font: inherit;
  text-transform: none;
  display: inline-block;
  vertical-align: middle;
  text-decoration: none;
  text-align: center;
}
.c-button:hover,
.c-button:focus {
  outline: none;
  text-decoration: none;
}
.c-button:not(:disabled) {
  cursor: pointer;
}

.c-button-dropdown {
  padding: 6px 34px 6px 12px;
  background-color: #967adc;
  color: #e6e9ed;
  font-size: 14px;
  line-height: 20px;
  min-height: 32px;
  border-radius: 3px;
}
.c-button-dropdown:hover {
  background-color: #ac92ec;
}
.c-button-dropdown:after {
  content: "";
  position: absolute;
  top: 14px;
  right: 11px;
  width: 0;
  height: 0;
  border: 5px solid transparent;
  border-top-color: #e6e9ed;
}

.show-tags-enter-active {
  animation: bounce-in 0.5s;
}
.show-tags-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

@media only screen and (min-width: 769px) and (max-width: 1400px) {
  .write {
    width: 95%;
  }
  .center .file {
    padding: 20px 5px;
    margin-left: 5px;
  }

  .imgContainer {
    height: 100px;
  }
}

@media only screen and (max-width: 768px) {
  .title-top .title,
  .center .markdown,
  .center .file {
    width: 100%;
  }
  .center .file,
  .c-dropdown {
    margin-top: 10px;
  }
}
</style>
