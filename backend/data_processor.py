import pandas as pd
import os

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

INDUSTRIAL_FILE = os.path.join(
    BASE_DIR,
    "data",
    "industrial_safety",
    "IHMStefanini_industrial_safety_and_health_database_with_accidents_description.csv"
)

OSHA_FILE = os.path.join(
    BASE_DIR,
    "data",
    "osha",
    "ITA_Case_Detail_Data_2025_through_3-15-2026.csv"
)


def load_industrial_data():
    try:
        df = pd.read_csv(INDUSTRIAL_FILE)

        df.columns = [
            str(col).strip().replace(" ", "_")
            for col in df.columns
        ]

        return df

    except Exception as e:
        print("Industrial dataset error:", e)
        return pd.DataFrame()


def load_osha_data(limit=5000):
    """
    Reads only a sample of the large OSHA dataset.
    This prevents the 400MB file from consuming too much memory.
    """

    try:
        df = pd.read_csv(
            OSHA_FILE,
            nrows=limit,
            low_memory=False
        )

        df.columns = [
            str(col).strip().replace(" ", "_")
            for col in df.columns
        ]

        return df

    except Exception as e:
        print("OSHA dataset error:", e)
        return pd.DataFrame()


def get_statistics():

    industrial = load_industrial_data()

    return {
        "total_reports": len(industrial),
        "high_potential": int(
            (industrial["Potential_Accident_Level"].astype(str) == "IV").sum()
        ) if "Potential_Accident_Level" in industrial.columns else 0,

        "industries": industrial["Industry_Sector"].value_counts().to_dict()
        if "Industry_Sector" in industrial.columns else {}
    }


if __name__ == "__main__":

    df = load_industrial_data()

    print("Industrial Safety Records:", len(df))

    print("\nColumns:")
    print(df.columns.tolist())

    print("\nFirst 5 records:")
    print(df.head())