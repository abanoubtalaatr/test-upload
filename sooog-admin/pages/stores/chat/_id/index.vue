<template>
 <div>
    <title-bar :title-stack="titleStack" />
    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <div
          class="col-8 d-flex flex-column p-0 justify-content-between p-3 border border-top-0 chatScreen"
        >
          <div class="d-flex flex-column justify-content-between chat">
            <div class="d-flex flex-column m-auto text-center justify-content-center mb-2 header">
              <h2 class="fw-bold">{{chat.user.name}}</h2>
              <p class="text-muted" v-if="chat.messages.length === 0">
               No messages yet!!
              </p>
            </div>
            <div class="messages">
              <div
              v-for="msg in msgs"
              :key="msg.id"
              class="d-flex gap-2 w-75 mb-4 bubble"
              :class="store_id == msg.sender.id ? 'self' : '' "
              >

                <img :src="msg.sender.avatar" width="50" height="50" alt="avatar"/>
                <div class="text">
                  <div class="username fw-bold">{{msg.sender.name}}</div>
                  <div class="chatfield p-2">
                    <span v-if="msg.message_type=='text'" > {{msg.message}}</span>
                    <span v-if="msg.message_type=='image'" >  <img :src="msg.message" width="150" height="150" alt="msg"/></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="chatbox-wrapper">
            <input
              type="text"
              class="chatbox px-3 p-2"
              placeholder="Send a message..."
            @keyup.enter="sendMessage()"
            />

          </div>
        </div>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

<!--<style scoped>-->
  <!--.chatbox {-->
    <!--outline: none;-->
    <!--border: none;-->
    <!--border-radius: 10px;-->
    <!--font-size: 1rem;-->
    <!--background: var(&#45;&#45;white3);-->
    <!--transition: 0.2s;-->
    <!--color: var(&#45;&#45;black2);-->
    <!--width: 100%;-->
  <!--}-->

  <!--.header {-->
    <!--width: 100%;-->
    <!--border-bottom: 2px var(&#45;&#45;gray1) solid;-->
  <!--}-->

  <!--h2 {-->
    <!--color: var(&#45;&#45;purple1);-->
  <!--}-->

  <!--.messages {-->
    <!--position: relative;-->
    <!--height: 70vh;-->
    <!--width: 100%;-->
    <!--padding-right: 2em;-->
    <!--overflow: auto;-->
  <!--}-->

  <!--.messages::-webkit-scrollbar {-->
    <!--background: #d8d6d6;-->
    <!--width: 8px;-->
    <!--border-radius: 5px;-->
  <!--}-->

  <!--.messages::-webkit-scrollbar-thumb {-->
    <!--border-radius: 5px;-->
    <!--background: var(&#45;&#45;purple1hover);-->
  <!--}-->

  <!--.chatfield {-->
    <!--background: var(&#45;&#45;purple1);-->
    <!--color: var(&#45;&#45;white2);-->
    <!--border-radius: 10px;-->
    <!--border-top-left-radius: 0;-->
  <!--}-->

  <!--.chatbox:focus,-->
  <!--.self .chatfield {-->
    <!--background: var(&#45;&#45;purple2);-->
    <!--color: var(&#45;&#45;black1);-->
  <!--}-->

  <!--.self .chatfield {-->
    <!--border-top-right-radius: 0;-->
    <!--border-top-left-radius: 10px;-->
  <!--}-->

  <!--.chatfield {-->
    <!--font-size: 1rem;-->
    <!--width: fit-content;-->
  <!--}-->

  <!--.bubble {-->
    <!--flex-flow: row;-->
  <!--}-->

  <!--.bubble.self {-->
    <!--flex-flow: row-reverse;-->
  <!--}-->

  <!--.self .chatfield {-->
    <!--float: right;-->
  <!--}-->

  <!--.self {-->
    <!--text-align: right;-->
    <!--float: right;-->
    <!--flex-flow: row-reverse;-->
  <!--}-->

  <!--img {-->
    <!-- -webkit-user-drag: none;-->
  <!--}-->

  <!--@media screen and (max-width: 968px) {-->
    <!--.chatScreen {-->
      <!--position: fixed;-->
      <!--width: 100%;-->
      <!--height: calc(100% - 60px);-->
    <!--}-->

    <!--.chatbox-wrapper {-->
      <!--position: absolute;-->
      <!--background: var(&#45;&#45;white1);-->
      <!--width: 93%;-->
      <!--display: flex;-->
      <!--justify-content: center;-->
      <!--bottom: 0;-->
      <!--align-items: center;-->
      <!--left: 0;-->
    <!--}-->

    <!--.chatbox {-->
      <!--width: 100%;-->
      <!--margin: 1em;-->
    <!--}-->
  <!--}-->
<!--</style>-->
