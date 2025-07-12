<template>
  <div>
    <input
      v-model="searchQuery"
      placeholder="Search location..."
      class="form-control"
    />
    <div id="map" style="height: 400px;"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: ''
    };
  }
};
</script>
