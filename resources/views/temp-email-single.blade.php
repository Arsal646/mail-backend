<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Temporary Email Inbox</title>
<meta name="csrf-token" content="<?= csrf_token() ?>">

<style>
  /* ===== Base ===== */
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: #2d3748;
    padding: 1rem;
  }

  .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 0;
  }

  h1 { 
    text-align: center; 
    margin-bottom: 3rem; 
    font-weight: 700; 
    color: #fff;
    font-size: 2.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  /* ===== Email Display Card ===== */
  .email-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .email-display {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .email-icon {
    width: 24px;
    height: 24px;
    fill: #667eea;
  }

  .email-address {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2d3748;
    flex: 1;
    word-break: break-all;
    padding: 0.75rem 1rem;
    background: #f7fafc;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
  }

  .action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-primary {
    background: #667eea;
    color: white;
  }

  .btn-primary:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  }

  .btn-secondary {
    background: #48bb78;
    color: white;
  }

  .btn-secondary:hover {
    background: #38a169;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
  }

  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }

  /* ===== Status Bar ===== */
  .status-bar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1rem 2rem;
    margin-bottom: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .status-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
  }

  .status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #48bb78;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }

  .message-count {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
  }

  /* ===== Messages Container ===== */
  .inbox-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-height: 200px;
  }

  .message {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
  }

  .message:hover { 
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); 
    transform: translateY(-2px);
  }

  .message:last-child {
    margin-bottom: 0;
  }

  .subject { 
    font-weight: 700; 
    font-size: 1.25rem; 
    color: #2b6cb0; 
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .meta { 
    font-size: 0.9rem; 
    color: #718096; 
    margin-bottom: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .body { 
    white-space: pre-wrap; 
    line-height: 1.6; 
    color: #4a5568;
    border-top: 1px solid #e2e8f0; 
    padding-top: 1rem;
    max-height: 300px;
    overflow-y: auto;
  }

  .no-msg { 
    text-align: center; 
    color: #a0aec0; 
    font-style: italic; 
    margin-top: 2rem; 
    font-size: 1.1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }

  .loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* ===== Responsive Design ===== */
  @media (max-width: 768px) {
    .container {
      padding: 1rem 0;
    }
    
    h1 {
      font-size: 2rem;
      margin-bottom: 2rem;
    }
    
    .email-card, .inbox-container {
      padding: 1.5rem;
    }
    
    .email-display {
      flex-direction: column;
      align-items: stretch;
    }
    
    .action-buttons {
      justify-content: center;
    }
    
    .status-bar {
      flex-direction: column;
      gap: 1rem;
      text-align: center;
    }
    
    .meta {
      flex-direction: column;
      gap: 0.5rem;
    }
  }
</style>
</head>
<body>

<div class="container">
  <h1>📧 Temporary Email Inbox</h1>

  <div class="email-card">
    <div class="email-display">
      <svg class="email-icon" viewBox="0 0 24 24">
        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.89 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
      </svg>
      <div class="email-address" id="temp-email"><?php echo htmlspecialchars($email); ?></div>
    </div>
    
    <div class="action-buttons">
      <button class="btn btn-primary" id="copy-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
          <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
        </svg>
        Copy Email
      </button>
      <button class="btn btn-secondary" id="refresh-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
        Refresh
      </button>
      <button class="btn btn-accent" id="send-btn">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
    <path d="M2 21l21-9L2 3v7l15 2-15 2z"/>
  </svg>
  Send Test Email
</button>
    </div>
  </div>

  <div class="status-bar">
    <div class="status-info">
      <div class="status-dot"></div>
      <span id="status-text">Auto-refreshing every 15 seconds</span>
    </div>
    <div class="message-count" id="message-count">0 messages</div>
  </div>

  <div class="inbox-container" id="inbox-container">
    <div class="no-msg">
      <div class="loading"></div>
      <span>Loading inbox messages...</span>
    </div>
  </div>
</div>

<script>
  const email = <?php echo json_encode($email); ?>;
  const inboxContainer = document.getElementById('inbox-container');
  const refreshBtn = document.getElementById('refresh-btn');
  const copyBtn = document.getElementById('copy-btn');
  const statusText = document.getElementById('status-text');
  const messageCount = document.getElementById('message-count');
  
  let autoRefreshInterval;
  let messageCountNum = 0;

  /* ---- Copy button functionality ---- */
  copyBtn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(email);
      const originalText = copyBtn.innerHTML;
      copyBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Copied!';
      copyBtn.disabled = true;
      setTimeout(() => { 
        copyBtn.innerHTML = originalText; 
        copyBtn.disabled = false; 
      }, 2000);
    } catch (err) {
      copyBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>Error';
      setTimeout(() => { 
        copyBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>Copy Email'; 
      }, 2000);
    }
  });

  /* ---- Escape HTML function ---- */
  const escapeHtml = txt =>
    txt.replace(/[&<>"']/g, m =>
      ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m])
    );

  /* ---- Fetch inbox function ---- */
  async function fetchInbox() {
    try {
      statusText.textContent = 'Checking for new messages...';
      
      const res = await fetch(`/inbox/${encodeURIComponent(email)}`);
      if (!res.ok) throw new Error('Fetch failed');
      const msgs = await res.json();
      
      messageCountNum = msgs.length;
      messageCount.textContent = `${messageCountNum} message${messageCountNum !== 1 ? 's' : ''}`;
      
      if (msgs.length === 0) {
        inboxContainer.innerHTML = `
          <div class="no-msg">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="#a0aec0">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.89 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <span>No messages received yet</span>
            <small style="color: #cbd5e0;">Messages will appear here automatically</small>
          </div>`;
        statusText.textContent = 'Waiting for new messages...';
        return;
      }

      inboxContainer.innerHTML = '';
      msgs.forEach(msg => {
        const subject = msg.Content.Headers.Subject?.[0] || '(No Subject)';
        const from = msg.From.Mailbox + '@' + msg.From.Domain;
        const date = msg.Content.Headers.Date?.[0] || 'Unknown';
        const body = msg.Content.Body || '';

        const messageEl = document.createElement('div');
        messageEl.className = 'message';
        messageEl.innerHTML = `
          <div class="subject">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.89 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            ${escapeHtml(subject)}
          </div>
          <div class="meta">
            <div class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
              From: ${escapeHtml(from)}
            </div>
            <div class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 11H7v6h2v-6zm4 0h-2v6h2v-6zm4 0h-2v6h2v-6zm2-7h-3V2h-2v2H8V2H6v2H3v2h18V4zM3 8h18v12H3V8z"/>
              </svg>
              ${escapeHtml(date)}
            </div>
          </div>
          <div class="body">${escapeHtml(body).replace(/\n/g, '<br>')}</div>
        `;
        inboxContainer.appendChild(messageEl);
      });
      
      statusText.textContent = 'Auto-refreshing every 15 seconds';
    } catch (err) {
      inboxContainer.innerHTML = `
        <div class="no-msg">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="#e53e3e">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
          </svg>
          <span>Error loading inbox</span>
          <small style="color: #cbd5e0;">Please try refreshing manually</small>
        </div>`;
      statusText.textContent = 'Error occurred - auto-refresh paused';
      console.error('Inbox fetch error:', err);
    }
  }

  /* ---- Auto-refresh functionality ---- */
  function startAutoRefresh() {
    autoRefreshInterval = setInterval(fetchInbox, 15000); // 15 seconds
  }

  function stopAutoRefresh() {
    if (autoRefreshInterval) {
      clearInterval(autoRefreshInterval);
    }
  }

  /* ---- Manual refresh ---- */
  refreshBtn.addEventListener('click', () => {
    stopAutoRefresh();
    fetchInbox();
    startAutoRefresh();
  });

  /* ---- Page visibility handling ---- */
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      stopAutoRefresh();
    } else {
      fetchInbox();
      startAutoRefresh();
    }
  });


  /* ---- Send‑email button ---- */
const sendBtn = document.getElementById('send-btn');

sendBtn.addEventListener('click', async () => {
  const original = sendBtn.innerHTML;
  sendBtn.disabled = true;
  sendBtn.innerHTML = `<span class="loading"></span> Sending…`;

  try {
    const res = await fetch('/send-email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ email })
    });

    if (res.ok) {
      sendBtn.innerHTML = '✅ Sent!';
      // optionally refresh inbox right away:
      fetchInbox();
    } else {
      throw new Error(await res.text());
    }
  } catch (err) {
    console.error(err);
    sendBtn.innerHTML = '❌ Error';
  } finally {
    setTimeout(() => {
      sendBtn.innerHTML = original;
      sendBtn.disabled  = false;
    }, 2000);
  }
});


  /* ---- Initialize ---- */
  fetchInbox();
  startAutoRefresh();
</script>

</body>
</html>