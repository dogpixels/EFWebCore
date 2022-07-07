using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[CreateAssetMenu(fileName = "New Equipment", menuName = "Inventory/Equipment")]
public class Equipment : Item
{
    public EquipmentSlot equipSlot; //Slot to store equipment in
    public SkinnedMeshRenderer mesh;
    public EquipmentMeshRegion[] coveredMeshRegions;

    public int armorModifier; //Increase Armor Stat
    public int damageModifier; //Damage Stat
    public int backpackplus; //Increases size of the Inventory

    //what happens at buttonpress in inventory:
    public override void Use()
    {
        base.Use();
        EquipmentManager.instance.Equip(this);      //Equip the Item
        RemoveFromInventory();                      //Remove it from the inventory 
    }
}


public enum EquipmentSlot {Head, Chest, Legs, Weapon, Shield, Feet }
public enum EquipmentMeshRegion {Arms, Legs, Torso }; //Corresponds to body blendshapes