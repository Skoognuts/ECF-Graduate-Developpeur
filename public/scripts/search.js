jQuery( document ).ready(function() {
  const inputPartner = document.getElementById('searchForPartner');
  const outputPartner = document.getElementById('partnerSearch');

  const partnerCities = document.getElementsByClassName('partnerCity');
  const partnerUrls = document.getElementsByClassName('partnerUrl');

  let partnerCitiesFormatted = [];
  let partnerUrlsFormatted = [];
  
  for (let i = 0; i < partnerCities.length; i++) {
    partnerCitiesFormatted.push(partnerCities.item(i).textContent);
  }

  for (let i = 0; i < partnerUrls.length; i++) {
    partnerUrlsFormatted.push(partnerUrls.item(i).href);
  }

  const inputPartnerHandler = function(e) {
    if (e.target.value != '') {
      partnerCitiesFormatted.forEach(function(value, index) {
        if (value.startsWith(Array.from(e.target.value.toUpperCase())[0])) {
          $('<ul class="m-0"><li><a class="small" href="' + partnerUrlsFormatted[index] + '">' + value + '</a></li></ul>').appendTo(outputPartner);
        }
      });
    } else {
      outputPartner.innerHTML = null;
    }
  }

  const inputStructure = document.getElementById('searchForStructure');
  const outputStructure = document.getElementById('structureSearch');

  const structureCities = document.getElementsByClassName('structureCity');
  const structureAddresses = document.getElementsByClassName('structureAddress');
  const structureUrls = document.getElementsByClassName('structureUrl');

  let structureCitiesFormatted = [];
  let structureAddressesFormatted = [];
  let structureUrlsFormatted = [];

  for (let i = 0; i < structureCities.length; i++) {
    structureCitiesFormatted.push(structureCities.item(i).textContent);
  }

  for (let i = 0; i < structureAddresses.length; i++) {
    structureAddressesFormatted.push(structureAddresses.item(i).textContent);
  }

  for (let i = 0; i < structureUrls.length; i++) {
    structureUrlsFormatted.push(structureUrls.item(i).href);
  }

  const inputStructureHandler = function(e) {
    if (e.target.value != '') {
      $('<ul class="m-0" id="results">').appendTo(outputStructure);
      structureCitiesFormatted.forEach(function(value, index) {
        if (value.startsWith(Array.from(e.target.value.toUpperCase())[0])) {
          $('<li><a class="small" href="' + structureUrlsFormatted[index] + '">' + value + ' - ' +structureAddressesFormatted[index] + '</a></li>').appendTo('#results');
        }
      })
    } else {
      outputStructure.innerHTML = null;
    }
  }

  inputPartner.addEventListener('input', inputPartnerHandler);
  inputStructure.addEventListener('input', inputStructureHandler);
})
