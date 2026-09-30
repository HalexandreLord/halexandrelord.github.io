let state={questions:[],duration:120,endAt:0,submitted:false,student:null};

const $=id=>document.getElementById(id);
async function api(url, options={}){
  const r=await fetch(url,{credentials:"same-origin",headers:{"Content-Type":"application/json"},...options});
  const data=await r.json().catch(()=>({ok:false,message:"Resposta inválida do servidor."}));
  if(!r.ok || data.ok===false) throw new Error(data.message||"Erro na operação.");
  return data;
}

async function startExam(e){
  e.preventDefault();
  $("loginMsg").textContent="";
  try{
    const data=await api("api/student_start.php",{method:"POST",body:JSON.stringify({
      name:$("name").value.trim(),studentCode:$("studentCode").value.trim()
    })});
    state.questions=data.questions; state.duration=data.duration; state.student=data.student;
    state.endAt=Date.now()+data.remainingSeconds*1000;
    $("loginCard").classList.add("hidden");
    $("examCard").classList.remove("hidden");
    $("studentName").textContent="• "+state.student.name;
    renderExam();
    tick();
  }catch(err){$("loginMsg").textContent=err.message}
}

function renderExam(){
  const form=$("examForm"); form.innerHTML="";
  state.questions.forEach((q,i)=>{
    const div=document.createElement("div"); div.className="question";
    const title=document.createElement("h3"); title.textContent=`${i+1}. ${q.question}`;
    div.appendChild(title);
    q.options.forEach((opt,j)=>{
      const label=document.createElement("label"); label.className="option";
      label.innerHTML=`<input type="radio" name="q${i}" value="${j}"> ${String.fromCharCode(65+j)}) ${escapeHtml(opt)}`;
      div.appendChild(label);
    });
    form.appendChild(div);
  });
}
function escapeHtml(s){return String(s).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"}[c]))}

function tick(){
  if(state.submitted)return;
  const sec=Math.max(0,Math.floor((state.endAt-Date.now())/1000));
  const h=String(Math.floor(sec/3600)).padStart(2,"0");
  const m=String(Math.floor(sec%3600/60)).padStart(2,"0");
  const s=String(sec%60).padStart(2,"0");
  $("timer").textContent=`${h}:${m}:${s}`;
  if(sec<=0){submitExam(true);return}
  setTimeout(tick,1000);
}

async function submitExam(auto=false){
  if(state.submitted)return;
  const answers=[];
  for(let i=0;i<state.questions.length;i++){
    const checked=document.querySelector(`input[name="q${i}"]:checked`);
    if(!checked && !auto){$("examMsg").textContent=`A questão ${i+1} não foi respondida.`;document.querySelectorAll(".question")[i].scrollIntoView({behavior:"smooth"});return}
    answers.push(checked?Number(checked.value):null);
  }
  if(!auto && !confirm("Tem certeza que deseja terminar a prova?"))return;
  state.submitted=true;
  try{
    const data=await api("api/student_submit.php",{method:"POST",body:JSON.stringify({answers})});
    $("examCard").classList.add("hidden");$("resultCard").classList.remove("hidden");
    $("result").innerHTML=`<p>Aluno: <strong>${escapeHtml(data.student.name)}</strong></p>
      <p class="score">${data.score}/${data.total} questões corretas</p>
      <p>Nota: <strong>${data.grade.toFixed(1)}</strong> / 10,0</p>
      <p>${auto?"A prova foi encerrada automaticamente pelo término do tempo.":"Prova finalizada com sucesso."}</p>`;
    $("logoutBtn").classList.remove("hidden");
  }catch(err){state.submitted=false;$("examMsg").textContent=err.message}
}
$("loginForm").addEventListener("submit",startExam);
$("finishBtn").addEventListener("click",()=>submitExam(false));
$("pdfBtn").addEventListener("click",()=>window.print());
$("logoutBtn").addEventListener("click",()=>location.reload());
$("newExamBtn").addEventListener("click",()=>location.reload());
