<template>
    <div>
        <input 
            v-model="searchQuery" 
            @input="searchPlaces"
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
            searchQuery: '',
            map: null,
            marker: null,
        };
    },

    methods: {
        initMap() {
            this.map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8,
            });
        },

                if (response.data) {
                    this.updateMap(response.data.lat, response.data.lng);
                }
            } catch (error) {
                console.error('Geocoding failed:', error);
            }
        },

            this.marker = new google.maps.Marker({
                position,
                map: this.map,
                title: this.searchQuery,
            });

};
</script>
