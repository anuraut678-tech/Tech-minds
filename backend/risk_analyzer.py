SIF_SCORES = {
    "I": 20,
    "II": 40,
    "III": 60,
    "IV": 80,
    "V": 100
}


def sif_to_score(sif_potential):
    return SIF_SCORES.get(str(sif_potential).upper(), 0)


def get_risk_level(score):

    if score >= 80:
        return "CRITICAL"

    elif score >= 60:
        return "HIGH"

    elif score >= 40:
        return "MEDIUM"

    return "LOW"


def get_recommendation(hazard, failed_barrier):

    recommendations = {

        "Line of Fire":
            "Establish exclusion zones and prevent personnel from entering the line of fire.",

        "Electrical":
            "Verify isolation and implement Lock-Out/Tag-Out before work begins.",

        "Confined Space":
            "Perform atmospheric testing and verify confined-space entry controls.",

        "Working at Height":
            "Verify fall protection, access equipment and edge protection.",

        "Chemical Exposure":
            "Verify chemical controls, PPE and emergency response arrangements.",

        "Machine / Mechanical":
            "Verify machine guarding and energy isolation before maintenance."
    }

    action = recommendations.get(
        hazard,
        "Review the hazard and strengthen the required safety barriers."
    )

    if failed_barrier and failed_barrier != "Unknown":
        action += " Priority barrier check: " + str(failed_barrier) + "."

    return action


def generate_risk_result(analysis):

    sif_potential = analysis.get("sif_potential", "I")

    score = sif_to_score(sif_potential)

    return {
        "sif_potential": sif_potential,
        "score": score,
        "risk_level": get_risk_level(score),
        "recommendation": get_recommendation(
            analysis.get("hazard", "Unknown"),
            analysis.get("failed_barrier", "Unknown")
        )
    }