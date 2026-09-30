const $=id=>document.getElementById(id);
async function api(url,options={}){
  const r=await fetch(url,{credentials:"same-origin",headers:{"Content-Type":"application/json"},...options});
  const d=await r.json().catch(()=>({ok:false,message:"Resposta inválida."}));
  if(!r.ok||d.ok===false)throw new Error(d.message||"Erro.");
  return d;
}
function esc(s){return String(s).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"}[c]))}

async function load(){
  try{
    const d=await api("api/admin_data.php");
    $("adminLogin").classList.add("hidden");$("adminPanel").classList.remove("hidden");$("adminLogout").classList.remove("hidden");
    $("examTitle").value=d.settings.title;$("duration").value=d.settings.duration;
    renderQuestions(d.questions);renderResults(d.results);
  }catch(e){$("adminMsg").textContent=e.message}
}
function renderQuestions(qs){
  const root=$("questionsEditor");root.innerHTML="";
  qs.forEach((q,i)=>{
    const box=document.createElement("div");box.className="question";
    box.innerHTML=`<h3>Questão ${i+1}</h3>
      <label>Enunciado<textarea class="qtext">${esc(q.question)}</textarea></label>`;
    q.options.forEach((o,j)=>{
      box.innerHTML+=`<label>Alternativa ${String.fromCharCode(65+j)}
        <input class="opt" data-j="${j}" value="${esc(o)}"></label>`;
    });
    box.innerHTML+=`<label>Resposta correta
      <select class="correct">
        ${q.options.map((o,j)=>`<option value="${j}" ${j===q.correct?"selected":""}>${String.fromCharCode(65+j)}</option>`).join("")}
      </select></label>`;
    root.appendChild(box);
  });
}
function collectQuestions(){
  return [...document.querySelectorAll("#questionsEditor .question")].map(box=>({
    question:box.querySelector(".qtext").value.trim(),
    options:[...box.querySelectorAll(".opt")].sort((a,b)=>Number(a.dataset.j)-Number(b.dataset.j)).map(x=>x.value.trim()),
    correct:Number(box.querySelector(".correct").value)
  }));
}
async function saveQuestions(){
  try{await api("api/admin_save.php",{method:"POST",body:JSON.stringify({type:"questions",questions:collectQuestions()})});alert("Questões salvas.");load()}
  catch(e){alert(e.message)}
}
async function saveSettings(){
  try{await api("api/admin_save.php",{method:"POST",body:JSON.stringify({type:"settings",title:$("examTitle").value.trim(),duration:Number($("duration").value)})});alert("Configurações salvas.");}
  catch(e){alert(e.message)}
}
function renderResults(rows){
  $("resultsBody").innerHTML=rows.map(r=>`<tr><td>${esc(r.name)}</td><td>${esc(r.student_code)}</td><td>${r.score}/${r.total} — ${Number(r.grade).toFixed(1)}</td><td>${esc(r.finished_at)}</td></tr>`).join("")||"<tr><td colspan='4'>Nenhuma prova realizada.</td></tr>";
}
$("adminLoginForm").addEventListener("submit",async e=>{e.preventDefault();try{await api("api/admin_login.php",{method:"POST",body:JSON.stringify({password:$("adminPassword").value})});load()}catch(x){$("adminMsg").textContent=x.message}});
$("saveQuestions").addEventListener("click",saveQuestions);
$("saveSettings").addEventListener("click",saveSettings);
$("adminLogout").addEventListener("click",async()=>{await api("api/admin_logout.php",{method:"POST"});location.reload()});
load();
