document.getElementById("familySearch").addEventListener("input", function () {
  const keyword = this.value.toLowerCase();
  document.querySelectorAll(".family-card").forEach(card => {
    const match = card.textContent.toLowerCase().includes(keyword);
    card.style.display = match ? "flex" : "none";
  });
});

document.getElementById("searchInput").addEventListener("input", function () {
  const query = this.value.toLowerCase();
  const trips = document.querySelectorAll(".trip-item");

  trips.forEach(trip => {
    const match = trip.textContent.toLowerCase().includes(query);
    trip.style.display = match ? "flex" : "none";
  });
});

