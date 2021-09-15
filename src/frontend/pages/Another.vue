<template>
  <div class="profile">
    <h3>Simple Signup Form</h3>
    <SignupForm />
  </div>
</template>

<script>
import SignupForm from '../components/SignupForm.vue'

export default {

  name: 'Another',
  components: {
    SignupForm
  },
  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>
