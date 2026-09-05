"""
ai_analyzer.py
--------------
Owner: Neetu (Member 1)

Job: Take a raw safety report (plain text) and use Gemini (Google's LLM)
to extract structured fields:
    hazard, activity, location, sif_potential,
    failed_barrier, consequence, recommendation

sif_potential uses the SAME I-V scale as the "Potential Accident Level"
column in the Industrial Safety dataset.
"""

import os
import json
from google import genai
from dotenv import load_dotenv

load_dotenv()
client = genai.Client(api_key=os.getenv("GEMINI_API_KEY"))

SYSTEM_PROMPT = """You are a safety analyst assistant.
Given a workplace safety incident report, extract the following fields
and respond with ONLY valid JSON (no extra text, no markdown, no
explanations, no ```json fences). Use these exact keys:

{
  "hazard": "...",
  "activity": "...",
  "location": "...",
  "sif_potential": "I" | "II" | "III" | "IV" | "V",
  "failed_barrier": "...",
  "consequence": "...",
  "recommendation": "..."
}

Rules for sif_potential (Potential Accident Level scale):
- "I"   = Minor / low potential for serious harm
- "II"  = Low-moderate potential
- "III" = Moderate potential for serious injury
- "IV"  = High potential for serious injury or fatality
- "V"   = Very high / severe potential, life-threatening or fatal

If a field cannot be determined from the report, use "Unknown" as the
value (except sif_potential, which must always be one of I-V; make your
best judgment even if uncertain).
Do not add any fields other than the ones listed above.
"""


def analyze_report(report_text: str) -> dict:
    try:
        response = client.models.generate_content(
           model="gemini-3.5-flash-lite",
            contents=f"{SYSTEM_PROMPT}\n\nIncident report:\n{report_text}",
        )

        raw_output = response.text.strip()

        if raw_output.startswith("```"):
            raw_output = raw_output.strip("`")
            raw_output = raw_output.replace("json", "", 1).strip()

        structured_data = json.loads(raw_output)

        valid_levels = {"I", "II", "III", "IV", "V"}
        if structured_data.get("sif_potential") not in valid_levels:
            structured_data["sif_potential"] = "Unknown"

        return structured_data

    except json.JSONDecodeError:
        return {
            "hazard": "Unknown",
            "activity": "Unknown",
            "location": "Unknown",
            "sif_potential": "Unknown",
            "failed_barrier": "Unknown",
            "consequence": "Unknown",
            "recommendation": "Unknown",
            "error": "AI response could not be parsed as JSON"
        }

    except Exception as e:
        return {"error": str(e)}


if __name__ == "__main__":
    sample_report = (
        "Worker was operating a crane near an active lifting zone "
        "without barricading. Risk of crush injury identified during "
        "the shift at Site B."
    )

    result = analyze_report(sample_report)
    print(json.dumps(result, indent=2))