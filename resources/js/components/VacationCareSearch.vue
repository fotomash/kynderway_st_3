<template>
  <div class="vacation-care-search">
    <div class="search-toggle">
      <button 
        @click="searchMode = 'home'" 
        :class="{ active: searchMode === 'home' }"
      >
        Search Near Home
      </button>
      <button 
        @click="searchMode = 'vacation'" 
        :class="{ active: searchMode === 'vacation' }"
      >
        Vacation Care
      </button>
    </div>
    
    <div v-if="searchMode === 'vacation'" class="vacation-search-form">
      <h3>Find Childcare for Your Trip</h3>
      
      <!-- Destination Search -->
      <div class="form-group">
        <label>Where are you going?</label>
        <input 
          v-model="vacationSearch.destination"
          @input="searchDestination"
          placeholder="City, hotel, or address"
          class="form-control"
        />
        <div v-if="destinationSuggestions.length" class="suggestions">
          <div 
            v-for="suggestion in destinationSuggestions"
            :key="suggestion.place_id"
            @click="selectDestination(suggestion)"
            class="suggestion-item"
          >
            {{ suggestion.description }}
          </div>
        </div>
      </div>
      
      <!-- Date Range -->
      <div class="form-group">
        <label>Travel Dates</label>
        <date-range-picker
          v-model="vacationSearch.dates"
          :min-date="tomorrow"
        />
      </div>
      
      <!-- Care Schedule -->
      <div class="form-group">
        <label>When do you need care?</label>
        <div class="care-schedule">
          <div 
            v-for="day in dateRange" 
            :key="day"
            class="day-schedule"
          >
            <h4>{{ formatDate(day) }}</h4>
            <time-slot-picker
              v-model="vacationSearch.schedule[day]"
              :presets="['morning', 'afternoon', 'evening', 'overnight']"
            />
          </div>
        </div>
      </div>
      
      <!-- Accommodation Type -->
      <div class="form-group">
        <label>Where are you staying?</label>
        <select v-model="vacationSearch.accommodationType" class="form-control">
          <option value="hotel">Hotel</option>
          <option value="resort">Resort</option>
          <option value="airbnb">Airbnb/Vacation Rental</option>
          <option value="private_home">Private Home</option>
          <option value="other">Other</option>
        </select>
      </div>
      
      <!-- Search Options -->
      <div class="search-options">
        <label>
          <input 
            type="checkbox" 
            v-model="vacationSearch.includeLocalNannies"
          />
          Search for local nannies at destination
        </label>
        <label>
          <input 
            type="checkbox" 
            v-model="vacationSearch.includeTravelingNannies"
          />
          Include nannies willing to travel with us
        </label>
      </div>
      
      <button 
        @click="searchVacationCare" 
        class="btn btn-primary"
        :disabled="!canSearch"
      >
        Search Available Nannies
      </button>
    </div>
    
    <!-- Search Results -->
    <div v-if="searchResults" class="search-results">
      <div class="results-tabs">
        <button 
          @click="activeTab = 'local'"
          :class="{ active: activeTab === 'local' }"
        >
          Local Nannies ({{ searchResults.local_nannies.length }})
        </button>
        <button 
          @click="activeTab = 'traveling'"
          :class="{ active: activeTab === 'traveling' }"
          v-if="searchResults.traveling_nannies.length"
        >
          Traveling Nannies ({{ searchResults.traveling_nannies.length }})
        </button>
      </div>
      
      <div class="destination-insights" v-if="searchResults.destination_insights">
        <h4>{{ vacationSearch.destination }} Insights</h4>
        <div class="insights-grid">
          <div class="insight">
            <span class="label">Average Rate:</span>
            <span class="value">£{{ searchResults.destination_insights.average_hourly_rate }}/hr</span>
          </div>
          <div class="insight">
            <span class="label">Available Nannies:</span>
            <span class="value">{{ searchResults.destination_insights.available_nannies_count }}</span>
          </div>
        </div>
      </div>
      
      <div class="nanny-list">
        <nanny-card
          v-for="nanny in displayedNannies"
          :key="nanny.id"
          :nanny="nanny"
          :show-travel-cost="activeTab === 'traveling'"
          @select="selectNanny"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useLocationSearch } from '@/composables/useLocationSearch';
import { usePaymentCredits } from '@/composables/usePaymentCredits';

export default {
  setup() {
    const { searchDestination, searchVacationCare } = useLocationSearch();
    const { checkCredits } = usePaymentCredits();
    
    const searchMode = ref('home');
    const vacationSearch = ref({
      destination: '',
      dates: { start: null, end: null },
      schedule: {},
      accommodationType: 'hotel',
      includeLocalNannies: true,
      includeTravelingNannies: false,
    });
    
    const searchResults = ref(null);
    const activeTab = ref('local');
    
    const displayedNannies = computed(() => {
      if (!searchResults.value) return [];
      return activeTab.value === 'local' 
        ? searchResults.value.local_nannies 
        : searchResults.value.traveling_nannies;
    });

    const selectNanny = async (nanny) => {
      const hasCredits = await checkCredits();
      if (!hasCredits) {
        showCreditPurchaseModal();
        return;
      }
      router.push({
        name: 'nanny-profile',
        params: { id: nanny.id },
        query: {
          vacation: true,
          destination: vacationSearch.value.destination,
          dates: JSON.stringify(vacationSearch.value.dates)
        }
      });
    };

    return {
      searchMode,
      vacationSearch,
      searchResults,
      activeTab,
      displayedNannies,
      selectNanny,
      searchVacationCare,
    };
  }
};
</script>
