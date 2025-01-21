<template>
  <div v-show="valueMSG" class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <p v-for="(message, index) in messages" :key="index">
              <strong> {{ message.name }} fez uma reserva! </strong>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      valueMSG: true,
      messages: [],
    };
  },
  mounted() {
    Echo.channel("message-received").listen("SendMessage", (e) => {
      this.messages.splice(0), this.messages.push(e);
    });
  },
};
</script>
