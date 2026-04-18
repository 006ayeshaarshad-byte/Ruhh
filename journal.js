const clickSound = document.getElementById('clickSound');

function playClick() {
  clickSound?.play().catch(() => {}); // Simplified, currentTime/volume in HTML or default
}

// Mood to emoji map based on HTML options
const moodEmojis = {
  happy: '(˶˃ ᵕ ˂˶)',
  loved: '(´｡• ◡ •｡`)❤︎',
  sad: '(╥﹏╥)',
  angry: '( ,,⩌\'︿\'⩌ꐦ,,)',
  annoyed: '(￣へ￣)',
  'hug': '(つ｡˃ ᵕ ˂)つ',
  confused: '(´･_･`)',
  grateful: '(ㅅ´ ˘ `)',
  excited: '₍₍⚞(˶˃ ꒳ ˂˶)⚟⁾⁾'
};

let globalEntries = [];

async function loadNotes() {
  try {
    playClick();
    const response = await fetch('load-journal.php');
    if (!response.ok) throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    globalEntries = await response.json();
    console.log('Loaded entries:', globalEntries); // Debug
    const container = document.querySelector('.newnotes');
    if (!container) throw new Error('.newnotes not found');
    container.innerHTML = ''; // Clear existing
    if (globalEntries.length === 0) {
      console.log('No entries yet');
    } else {
      globalEntries.forEach(entry => createNoteElement(entry));
      renderMoodGraph(globalEntries);
    }
  } catch (error) {
    console.error('Load failed:', error);
    alert('Load failed: ' + error.message + '. Check console/F12.');
  }
}















function createNoteElement(entry) {
  const div = document.createElement('div');
  div.classList.add('mynote');

  const emoji = moodEmojis[entry.mood] || '?';

  div.innerHTML = `
    <h2>${entry.title || 'Untitled'}</h2>
    <p class="note-container">${entry.content || ''}</p>
    <p class="date">${entry.entry_date}</p>
    <p class="mood">${emoji} ${entry.mood}</p>
    <button class="delete-btn">Delete</button>
  `;

  div.dataset.entryId = entry.id;

  // ✅ DELETE BUTTON
  div.querySelector('.delete-btn').addEventListener('click', async (e) => {
    e.stopPropagation(); // ⭐ IMPORTANT: stops opening view

    const entryId = div.dataset.entryId;

    playClick();


    try {
      const formData = new FormData();
      formData.append('entry_id', entryId);

      const response = await fetch('delete-journal.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.status === 'success') {
        div.remove();
      } else {
        alert('Delete failed: ' + result.message);
      }
    } catch (e) {
      alert('Delete error: ' + e);
    }
  });

  // ✅ CLICK TO VIEW (with null check)
  div.addEventListener('click', function () {
    const viewNote = document.getElementById("viewNote");
    if (!viewNote) {
      console.error('View modal not found. Check HTML.');
      return;
    }
    const emoji = moodEmojis[entry.mood] || '?';

    document.getElementById("viewTitle").innerText = entry.title || 'Untitled';
    document.getElementById("viewDate").innerText = entry.entry_date || '';
    document.getElementById("viewMood").innerText = emoji + " " + entry.mood;
    document.getElementById("viewText").innerText = entry.content || '';

    viewNote.style.display = "flex";
  });


  document.querySelector('.newnotes').appendChild(div);
}










































































































// OPEN FORM
document.getElementById('addnote')?.addEventListener('click', function () {
  playClick();
  document.querySelector('.addform').style.display = 'block';
  document.getElementById('entryTitle').value = '';
  document.getElementById('entryContent').value = '';
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('entryDate').value = today;
  document.getElementById('entryMood').value = 'happy';
});

// CLOSE FORM (X BUTTON)
document.querySelector('.icon')?.addEventListener('click', function () {
  playClick();
  document.querySelector('.addform').style.display = 'none';
});

// SAVE NOTE
document.getElementById('addbtn')?.addEventListener('click', async function () {
  const title = document.getElementById('entryTitle').value.trim();
  const content = document.getElementById('entryContent').value.trim();
  const entryDate = document.getElementById('entryDate').value;
  const mood = document.getElementById('entryMood').value;

  if (!title || !content || !entryDate) {
    alert('Please fill title, thoughts, and date.');
    return;
  }

  try {
    playClick();
    const formData = new FormData();
    formData.append('title', title);
    formData.append('content', content);
    formData.append('entry_date', entryDate);
    formData.append('mood', mood);

    const response = await fetch('save-journal.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.json();
    if (result.status === 'success') {
      document.querySelector('.addform').style.display = 'none';
      loadNotes(); // Reload to show new note
    } else {
      alert('Save failed: ' + (result.message || result));
    }
  } catch (error) {
    alert('Error: ' + error.message);
  }
});

// Back button
document.getElementById('backBtn')?.addEventListener('click', () => {
  playClick();
  window.location.href = 'dashboard.php';
});

// Load notes on page load
document.addEventListener('DOMContentLoaded', loadNotes);

let moodChartInstance = null;

function renderMoodGraph(entries) {
  if (entries.length === 0) return;
  
  if (moodChartInstance) {
    moodChartInstance.destroy();
  }

// Mood labels for Y ticks (0-8)
  const moodTicks = ['Angry', 'Sad', 'Annoyed', 'Confused', 'Hug', 'Grateful', 'Excited', 'Loved', 'Happy'];
  
  const moodScores = {
    angry: 0, sad: 1, annoyed: 2, confused: 3, 'hug': 4,
    grateful: 5, excited: 6, loved: 7, happy: 8
  };


  
  entries.sort((a, b) => new Date(a.entry_date) - new Date(b.entry_date));
  
  const labels = [];
  const data = [];
  
  entries.forEach(entry => {
    labels.push(entry.entry_date);
    data.push(moodScores[entry.mood] || 4);
  });

  
  const ctx = document.getElementById('moodChart')?.getContext('2d');
  if (!ctx) return;
  
  moodChartInstance = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Mood Over Time',
        data: data,
        borderColor: '#992ca8',
        backgroundColor: 'rgba(153, 44, 168, 0.2)',
        tension: 0.4,
        fill: true,
        pointBackgroundColor: '#f2b1d9',
        pointBorderColor: '#992ca8',
        pointRadius: 6
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: { title: { display: true, text: 'Date' } },
        y: {
          min: 0,
          max: 8,
          ticks: {
            stepSize: 1,
            callback: function(value) {
              return moodTicks[value] || value;
            }
          },

          title: { display: true, text: 'Mood' }
        }
      },
      plugins: {
        legend: { display: true }
      }
    }
  });
}








// yei chat wala end par for view 


document.addEventListener("DOMContentLoaded", function () {
  // Close modal handlers
  const viewNote = document.getElementById("viewNote");
  const closeView = document.getElementById("closeView");
  if (viewNote && closeView) {
    closeView.addEventListener("click", () => { playClick(); viewNote.style.display = "none"; });

    
    // ESC key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && viewNote.style.display === 'flex') {
        viewNote.style.display = 'none';
      }
    });
    
    // Overlay click
    viewNote.addEventListener('click', (e) => {
      if (e.target === viewNote) viewNote.style.display = 'none';
    });
  }
});

