from fastapi import FastAPI
from pydantic import BaseModel

from backend.ai_analyzer import analyze_report
from backend.risk_analyzer import generate_risk_result

app = FastAPI(title="OIL SIF Detection API")


class SafetyReport(BaseModel):
    report: str


@app.get("/")
def home():
    return {
        "message": "OIL SIF Detection Backend is running"
    }


@app.post("/analyze")
def analyze(data: SafetyReport):

    # Step 1: Gemini se report analyze karo
    ai_result = analyze_report(data.report)

    # Agar AI mein error aaye
    if "error" in ai_result:
        return {
            "status": "error",
            "error": ai_result["error"]
        }

    # I-V potential level ko numeric score mein convert karo
    score_mapping = {
        "I": 20,
        "II": 40,
        "III": 60,
        "IV": 80,
        "V": 100
    }

    sif_score = score_mapping.get(
        ai_result.get("sif_potential"),
        0
    )

    # risk_analyzer ke expected format mein data
    risk_input = {
        "sif_score": sif_score,
        "hazard": ai_result.get("hazard", "Unknown"),
        "failed_barriers": [
            ai_result.get("failed_barrier", "Unknown")
        ]
    }

    # Step 2: Risk result generate karo
    risk_result = generate_risk_result(risk_input)

    # Final response
    return {
        "status": "success",
        "report": data.report,
        "analysis": ai_result,
        "risk": risk_result
    }