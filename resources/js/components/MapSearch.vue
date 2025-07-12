<template>
  <div class="map-search">
    <input
      v-model="searchQuery"
      @input="searchPlaces"
      placeholder="Search location..."
      class="form-control"
    />
    <div ref="map" id="map"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      map: null,
      markers: []
    };
  },
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {
      const center = { lat: 0, lng: 0 };
      this.map = new google.maps.Map(this.$refs.map, {
        zoom: 2,
        center
      });
    },
    searchPlaces() {
      if (!this.searchQuery || !this.map) return;
      const service = new google.maps.places.PlacesService(this.map);
      const request = {
        query: this.searchQuery,
        fields: ['name', 'geometry']
      };
      service.findPlaceFromQuery(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
          this.updateMap(results);
        }
      });
    },
    updateMap(places) {
      this.markers.forEach(m => m.setMap(null));
      this.markers = [];
      const bounds = new google.maps.LatLngBounds();
      places.forEach(place => {
        if (!place.geometry || !place.geometry.location) return;
        const marker = new google.maps.Marker({
          map: this.map,
          position: place.geometry.location
        });
        this.markers.push(marker);
        bounds.extend(place.geometry.location);
      });
      this.map.fitBounds(bounds);
    }
  }
};
</script>

<style scoped>
#map {
  width: 100%;
  height: 400px;
}
</style>
